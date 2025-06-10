<?php
$pageTitle = "Page Name";
ob_start();
?>
<?php
require_once '../models/Task.php';
require_once '../models/Category.php';

$error = '';
$categories = Category::getAll($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']) ?: null;
    $categoryId = $_POST['category'] ?: null;
    $priority = $_POST['priority'] ?? 'medium';
    $dueDate = $_POST['due_date'] ?: null;

    if (strlen($title) < 3 || strlen($title) > 100) {
        $error = "Title must be 3–100 characters.";
    } elseif (!in_array($priority, ['low', 'medium', 'high'])) {
        $error = "Invalid priority selected.";
    } elseif ($dueDate && !strtotime($dueDate)) {
        $error = "Invalid due date format.";
    } elseif ($description && strlen($description) > 1000) {
        $error = "Description must be under 1000 characters.";
    } else {
        if (Task::add($_SESSION['user_id'], $title, $description, $categoryId, $priority, $dueDate)) {
            header("Location: index.php?action=tasks");
            exit;
        } else {
            $error = "Failed to add task.";
        }
    }
}
?>

<h2>Add Task</h2>
<form method="post">
    Title: <input type="text" name="title" required><br>
    Description:<br>
    <textarea name="description" rows="4" cols="30"></textarea><br>
    Category:
    <select name="category">
        <option value="">-- None --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
        <?php endforeach; ?>
    </select><br>
    Priority:
    <select name="priority">
        <option value="low">Low</option>
        <option value="medium" selected>Medium</option>
        <option value="high">High</option>
    </select><br>
    Due Date: <input type="datetime-local" name="due_date"><br>
    <input type="submit" value="Add Task">
</form>
<p><a href="index.php?action=tasks">Back to Task List</a></p>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
