<?php
// actions/get_board_data.php

$result = ['columns' => [], 'users' => [], 'tags' => []];
$users_query = $conn->query("SELECT * FROM users ORDER BY name ASC");
while ($row = $users_query->fetch_assoc()) { $result['users'][] = $row; }
$tags_query = $conn->query("SELECT * FROM tags ORDER BY name ASC");
while ($row = $tags_query->fetch_assoc()) { $result['tags'][] = $row; }

$columns_query = $conn->query("SELECT * FROM `columns` ORDER BY position ASC");
while ($column = $columns_query->fetch_assoc()) {
    $column['tasks'] = [];
    $stmt = $conn->prepare("SELECT t.*, u.name as user_name FROM tasks t LEFT JOIN users u ON t.user_id = u.id WHERE t.column_id = ? ORDER BY t.position ASC");
    $stmt->bind_param("i", $column['id']);
    $stmt->execute();
    $tasks_result = $stmt->get_result();
    while ($task = $tasks_result->fetch_assoc()) {
        $task_id = $task['id'];
        $task['subtasks'] = []; $task['attachments'] = []; $task['comments'] = []; $task['tags'] = []; $task['activity_log'] = [];
        $subtask_stmt = $conn->prepare("SELECT * FROM subtasks WHERE task_id = ? ORDER BY id ASC");
        $subtask_stmt->bind_param("i", $task_id); $subtask_stmt->execute(); $subtasks_result = $subtask_stmt->get_result();
        while ($subtask = $subtasks_result->fetch_assoc()) { $task['subtasks'][] = $subtask; }
        $subtask_stmt->close();
        $att_stmt = $conn->prepare("SELECT * FROM attachments WHERE task_id = ? ORDER BY uploaded_at DESC");
        $att_stmt->bind_param("i", $task_id); $att_stmt->execute(); $atts_result = $att_stmt->get_result();
        while ($att = $atts_result->fetch_assoc()) { $task['attachments'][] = $att; }
        $att_stmt->close();
        $com_stmt = $conn->prepare("SELECT c.*, u.name as user_name FROM comments c LEFT JOIN users u ON c.user_id = u.id WHERE c.task_id = ? ORDER BY c.created_at DESC");
        $com_stmt->bind_param("i", $task_id); $com_stmt->execute(); $coms_result = $com_stmt->get_result();
        while ($com = $coms_result->fetch_assoc()) { $task['comments'][] = $com; }
        $com_stmt->close();
        $tag_stmt = $conn->prepare("SELECT t.* FROM tags t JOIN task_tags tt ON t.id = tt.tag_id WHERE tt.task_id = ?");
        $tag_stmt->bind_param("i", $task_id); $tag_stmt->execute(); $tags_result = $tag_stmt->get_result();
        while ($tag = $tags_result->fetch_assoc()) { $task['tags'][] = $tag; }
        $tag_stmt->close();
        $act_stmt = $conn->prepare("SELECT a.*, u.name as user_name FROM activity_log a LEFT JOIN users u ON a.user_id = u.id WHERE a.task_id = ? ORDER BY a.activity_date DESC LIMIT 10");
        $act_stmt->bind_param("i", $task_id); $act_stmt->execute(); $acts_result = $act_stmt->get_result();
        while ($act = $acts_result->fetch_assoc()) { $task['activity_log'][] = $act; }
        $act_stmt->close();
        $column['tasks'][] = $task;
    }
    $stmt->close();
    $result['columns'][] = $column;
}
echo json_encode(['status' => 'success', 'data' => $result]);
?>