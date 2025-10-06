<?php
// actions/move_task.php

$conn->begin_transaction();
try {
    $task_id = $data['taskId'];
    $new_column_id = $data['newColumnId'];
    $new_index = $data['newIndex'];
    $find_col_stmt = $conn->prepare("SELECT c.title FROM `columns` c JOIN tasks t ON c.id = t.column_id WHERE t.id = ?");
    $find_col_stmt->bind_param("i", $task_id); $find_col_stmt->execute();
    $old_column_title = $find_col_stmt->get_result()->fetch_assoc()['title'];
    $find_col_stmt->close();
    $old_column_id = $data['oldColumnId'];
    $old_index = $data['oldIndex'];
    $stmt = $conn->prepare("UPDATE tasks SET position = position - 1 WHERE column_id = ? AND position > ?");
    $stmt->bind_param("ii", $old_column_id, $old_index); $stmt->execute();
    $stmt = $conn->prepare("UPDATE tasks SET position = position + 1 WHERE column_id = ? AND position >= ?");
    $stmt->bind_param("ii", $new_column_id, $new_index); $stmt->execute();
    $stmt = $conn->prepare("UPDATE tasks SET column_id = ?, position = ? WHERE id = ?");
    $stmt->bind_param("iii", $new_column_id, $new_index, $task_id); $stmt->execute();
    $conn->commit();
    $find_col_stmt = $conn->prepare("SELECT title FROM `columns` WHERE id = ?");
    $find_col_stmt->bind_param("i", $new_column_id); $find_col_stmt->execute();
    $new_column_title = $find_col_stmt->get_result()->fetch_assoc()['title'];
    $find_col_stmt->close();
    log_activity($conn, $task_id, $data['current_user_id'] ?? null, "movió la tarea de '".$old_column_title."' a '".$new_column_title."'.");
    echo json_encode(['status' => 'success']);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500); echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>