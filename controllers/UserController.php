<?php
require_once __DIR__ . '/../models/User.php';

$action = $_GET['action'] ?? '';

if ($action === 'register') {
    include '../views/register.php';
} elseif ($action === 'login') {
    include '../views/login.php';
} elseif ($action === 'logout') {
    session_destroy();
    header('Location: /personal_task_manager_pro/public/index.php?action=login');
}