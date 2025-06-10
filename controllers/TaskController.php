<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../models/Category.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'tasks') {
    $sort = $_GET['sort'] ?? null;
    $tasks = Task::getAll($_SESSION['user_id'], $sort);
    include '../views/task_list.php';

} elseif ($action === 'add_task') {
    $categories = Category::getAll($_SESSION['user_id']);
    include '../views/add_task.php';

} elseif ($action === 'edit_task') {
    $taskId = $_GET['id'] ?? null;
    $task = Task::getById($_SESSION['user_id'], $taskId);
    if (!$task) {
        echo "<p>Task not found.</p>";
        exit;
    }
    $categories = Category::getAll($_SESSION['user_id']);
    include '../views/edit_task.php';

} elseif ($action === 'setStatus') {
    $taskId = $_GET['id'] ?? null;
    $status = $_GET['status'] ?? null;
    if (in_array($status, ['todo', 'in_progress', 'done'])) {
        Task::setStatus($_SESSION['user_id'], $taskId, $status);
    }
    header("Location: index.php?action=tasks");
    exit;

} elseif ($action === 'delete_task') {
    $taskId = $_GET['id'] ?? null;
    Task::delete($_SESSION['user_id'], $taskId);
    header("Location: index.php?action=tasks");
    exit;

} elseif ($action === 'search') {
    $categories = Category::getAll($_SESSION['user_id']);
    $results = [];
    $term = $_GET['term'] ?? '';
    $categoryId = $_GET['category'] ?? '';
    $priority = $_GET['priority'] ?? '';
    $status = $_GET['status'] ?? '';
    if ($term) {
        $results = Task::search($_SESSION['user_id'], $term, $categoryId, $priority, $status);
    }
    include '../views/search_tasks.php';

} elseif ($action === 'report') {
    $statusCounts = Task::countByStatus($_SESSION['user_id']);
    $overdueCount = Task::countOverdue($_SESSION['user_id']);
    $categorySummary = Task::categorySummary($_SESSION['user_id']);
    include '../views/report.php';
}