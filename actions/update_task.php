<?php
// actions/update_task.php

// Verificar autenticación
$current_user_id = $_SESSION['user_id'] ?? null;
if (!$current_user_id) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Debes iniciar sesión.']);
    exit;
}

// Permisos: el usuario debe poder gestionar el tablero de la tarea o ser admin
$task_id = $data['id'] ?? null;
if (!$task_id) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'ID de tarea no proporcionado.']);
    exit;
}

list($board_id, $col_id) = get_board_and_column_by_task($conn, $task_id);
if (!$board_id) {
    http_response_code(404);
    echo json_encode(['status' => 'error', 'message' => 'La tarea no existe.']);
    exit;
}
if (!can_manage_board($conn, $board_id, $current_user_id)) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'No tienes permiso para editar esta tarea.']);
    exit;
}

$user_id = empty($data['user_id']) ? null : $data['user_id'];
$due_date = empty($data['due_date']) ? null : $data['due_date'];
$priority = $data['priority'] ?? 'Media';

$stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, user_id = ?, due_date = ?, priority = ?, color = ? WHERE id = ?");
$stmt->bind_param("ssisssi", $data['title'], $data['description'], $user_id, $due_date, $priority, $data['color'], $task_id);
if ($stmt->execute()) {
    log_activity($conn, $task_id, $current_user_id, "actualizó los detalles de la tarea.");
    echo json_encode(['status' => 'success']);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>