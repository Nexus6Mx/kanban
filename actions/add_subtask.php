<?php
// actions/add_subtask.php

$stmt = $conn->prepare("INSERT INTO subtasks (task_id, title) VALUES (?, ?)");
$stmt->bind_param("is", $data['task_id'], $data['title']);
if ($stmt->execute()) {
    log_activity($conn, $data['task_id'], $data['current_user_id'] ?? null, "añadió la subtarea: ".$data['title']);
    echo json_encode(['status' => 'success', 'id' => $stmt->insert_id]);
} else { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => $stmt->error]); 
}
?>