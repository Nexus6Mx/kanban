<?php
// actions/update_column.php

$stmt = $conn->prepare("UPDATE `columns` SET title = ?, color = ?, wip_limit = ? WHERE id = ?");
$wip_limit = isset($data['wip_limit']) && $data['wip_limit'] > 0 ? $data['wip_limit'] : 0;
$stmt->bind_param("ssii", $data['title'], $data['color'], $wip_limit, $data['id']);
if ($stmt->execute()) { 
    echo json_encode(['status' => 'success']); 
} else { 
    http_response_code(500); 
    echo json_encode(['status' => 'error', 'message' => $stmt->error]); 
}
?>