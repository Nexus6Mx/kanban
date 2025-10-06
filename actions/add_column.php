<?php
// actions/add_column.php

$stmt = $conn->prepare("SELECT COALESCE(MAX(position), -1) + 1 AS next_pos FROM `columns`");
$stmt->execute(); 
$next_pos = $stmt->get_result()->fetch_assoc()['next_pos'];
$stmt = $conn->prepare("INSERT INTO `columns` (title, color, position, wip_limit) VALUES (?, ?, ?, ?)");
$wip_limit = isset($data['wip_limit']) && $data['wip_limit'] > 0 ? $data['wip_limit'] : 0;
$stmt->bind_param("ssii", $data['title'], $data['color'], $next_pos, $wip_limit);
if ($stmt->execute()) { 
    echo json_encode(['status' => 'success', 'id' => $stmt->insert_id]); 
} else { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => $stmt->error]); 
}
?>