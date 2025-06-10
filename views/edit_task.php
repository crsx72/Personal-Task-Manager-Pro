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
    $status = $_POST['status'] ?? 'todo';

    if (strlen($title) < 3 || strlen($title) > 100) {
        $error = "Title must be 3–100 characters.";
    } elseif (!in_array($priority, ['low', 'medium', 'high'])) {
        $error = "Invalid priority.";
    } elseif (!in_array($status, ['todo', 'in_progress', 'done'])) {
        $error = "Invalid status.";
    } elseif ($dueDate && !strtotime($dueDate)) {
        $error = "Invalid due date.";
    } elseif ($description && strlen($description) > 1000) {
        $error = "Description must be under 1000 characters.";
    } else {
        if (Task::update($_SESSION['user_id'], $task['id'], $title, $description, $categoryId, $priority, $dueDate, $status)) {
            header("Location: index.php?action=tasks");
            exit;
        } else {
            $error = "Update failed.";
        }
    }
}
?>

<h2>Edit Task</h2>
<form method="post">
    Title: <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required><br>
    Description:<br>
    <textarea name="description" rows="4" cols="30"><?= htmlspecialchars($task['description']) ?></textarea><br>
    Category:
    <select name="category">
        <option value="">-- None --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($task['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>
    Priority:
    <select name="priority">
        <?php foreach (['low', 'medium', 'high'] as $p): ?>
            <option value="<?= $p ?>" <?= ($task['priority'] == $p) ? 'selected' : '' ?>><?= ucfirst($p) ?></option>
        <?php endforeach; ?>
    </select><br>
    Due Date: <input type="datetime-local" name="due_date"
                     value="<?= $task['due_date'] ? date('Y-m-d\TH:i', strtotime($task['due_date'])) : '' ?>"><br>
    Status:
    <select name="status">
        <?php foreach (['todo', 'in_progress', 'done'] as $s): ?>
            <option value="<?= $s ?>" <?= ($task['status'] == $s) ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $s)) ?></option>
        <?php endforeach; ?>
    </select><br>
    <input type="submit" value="Update Task">
</form>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php
$content = ob_get_clean();
include 'layout.php';
?>
