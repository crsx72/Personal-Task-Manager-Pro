<?php
require_once __DIR__ . '/../models/Category.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit;
}

$action = $_GET['action'] ?? '';

if ($action === 'category_list') {
    $categories = Category::getAll($_SESSION['user_id']);
    include '../views/category_list.php';
} elseif ($action === 'add_category') {
    include '../views/add_category.php';
}