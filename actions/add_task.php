<?php
// actions/add_task.php

$stmt = $conn->prepare("SELECT COALESCE(MAX(position), -1) + 1 AS next_pos FROM tasks WHERE column_id = ?");
$stmt->bind_param("i", $data['column_id']); $stmt->execute();
$next_pos = $stmt->get_result()->fetch_assoc()['next_pos'];
$stmt->close();
$stmt = $conn->prepare("INSERT INTO tasks (column_id, title, description, user_id, due_date, priority, color, position) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$user_id = empty($data['user_id']) ? null : $data['user_id'];
$due_date = empty($data['due_date']) ? null : $data['due_date'];
$stmt->bind_param("ississsi", $data['column_id'], $data['title'], $data['description'], $user_id, $due_date, $data['priority'], $data['color'], $next_pos);
if ($stmt->execute()) {
    $task_id = $stmt->insert_id;
    log_activity($conn, $task_id, $data['current_user_id'] ?? null, "creó la tarea.");
    echo json_encode(['status' => 'success', 'id' => $task_id]);
} else {
    http_response_code(500); echo json_encode(['status' => 'error', 'message' => $stmt->error]);
}
?>