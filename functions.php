<?php
// Función de conexión a la BD
function db_connect($servername, $username, $password, $dbname) {
    try {
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            throw new Exception("Connection failed: " . $conn->connect_error);
        }
        $conn->set_charset("utf8mb4");
        return $conn;
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Database connection error: ' . $e->getMessage()]);
        exit;
    }
}

// Función para registrar actividad
function log_activity($conn, $task_id, $user_id, $activity_text) {
    $stmt = $conn->prepare("INSERT INTO activity_log (task_id, user_id, activity) VALUES (?, ?, ?)");
    $uid = $user_id ? $user_id : null;
    $stmt->bind_param("iis", $task_id, $uid, $activity_text);
    $stmt->execute();
    $stmt->close();
}
?>