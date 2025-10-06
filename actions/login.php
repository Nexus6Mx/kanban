<?php
// actions/login.php

$name = $data['name'] ?? '';
$password = $data['password'] ?? '';

if (empty($name) || empty($password)) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Faltan el nombre o la contraseña.']);
    exit;
}

// 1. Buscar al usuario por su nombre
$stmt = $conn->prepare("SELECT * FROM users WHERE name = ?");
$stmt->bind_param("s", $name);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    // 2. Verificar si la contraseña coincide con el hash guardado
    if (password_verify($password, $user['password'])) {
        // 3. Si es correcta, iniciar sesión y guardar los datos del usuario
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];

        echo json_encode([
            'status' => 'success',
            'user' => [
                'id' => $user['id'],
                'name' => $user['name']
            ]
        ]);
    } else {
        // Contraseña incorrecta
        http_response_code(401); // Unauthorized
        echo json_encode(['status' => 'error', 'message' => 'Credenciales inválidas.']);
    }
} else {
    // Usuario no encontrado
    http_response_code(401); // Unauthorized
    echo json_encode(['status' => 'error', 'message' => 'Credenciales inválidas.']);
}
?>