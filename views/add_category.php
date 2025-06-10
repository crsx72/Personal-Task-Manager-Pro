<?php
$pageTitle = "Page Name";
ob_start();
?>
<?php
require_once '../models/Category.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);

    if (strlen($name) < 3 || strlen($name) > 50) {
        $error = "Category name must be 3–50 characters.";
    } elseif (!Category::add($_SESSION['user_id'], $name)) {
        $error = "Category already exists.";
    } else {
        header("Location: index.php?action=category_list");
        exit;
    }
}
?>

<h2>Add Category</h2>
<form method="post">
    Name: <input type="text" name="name" required><br>
    <input type="submit" value="Add">
    <a href="index.php?action=category_list">Return to category list</a>
</form>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
