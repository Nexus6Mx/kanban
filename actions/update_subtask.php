<?php
// actions/update_subtask.php

$stmt = $conn->prepare("UPDATE subtasks SET title = ?, is_completed = ? WHERE id = ?");
$stmt->bind_param("sii", $data['title'], $data['is_completed'], $data['id']);
if ($stmt->execute()) { 
    echo json_encode(['status' => 'success']); 
} else { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => $stmt->error]); 
}
?>