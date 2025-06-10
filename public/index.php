<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$action = $_GET['action'] ?? 'home';

if ($action === 'home') {
    include '../views/home.php';

} elseif (in_array($action, ['register', 'login', 'logout'])) {
    require_once '../controllers/UserController.php';

} elseif (in_array($action, ['category_list', 'add_category'])) {
    require_once '../controllers/CategoryController.php';

} elseif (in_array($action, [
    'tasks', 'add_task', 'edit_task', 'delete_task',
    'setStatus', 'search', 'report'
])) {
    require_once '../controllers/TaskController.php';

} else {
    echo "<p>Invalid route: " . htmlspecialchars($action) . "</p>";
}