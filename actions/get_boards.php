<?php
// actions/get_boards.php

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Usuario no autenticado']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Por ahora, obtenemos los tableros donde el usuario es propietario.
// Más adelante se podría expandir para incluir tableros compartidos.
$stmt = $conn->prepare("SELECT id, name FROM boards WHERE owner_user_id = ? ORDER BY name");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$boards = [];
while ($row = $result->fetch_assoc()) {
    $boards[] = $row;
}

$stmt->close();

echo json_encode(['status' => 'success', 'data' => $boards]);
?>