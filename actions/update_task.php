<?php
// actions/update_task.php

$user_id = empty($data['user_id']) ? null : $data['user_id'];
$due_date = empty($data['due_date']) ? null : $data['due_date'];
$stmt = $conn->prepare("UPDATE tasks SET title = ?, description = ?, user_id = ?, due_date = ?, priority = ?, color = ? WHERE id = ?");
$stmt->bind_param("ssisssi", $data['title'], $data['description'], $user_id, $due_date, $data['priority'], $data['color'], $data['id']);
if ($stmt->execute()) {
    log_activity($conn, $data['id'], $data['current_user_id'] ?? null, "actualizó los detalles de la tarea.");
    echo json_encode(['status' => 'success']);
} else { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => $stmt->error]); 
}
?>