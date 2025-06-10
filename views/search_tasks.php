<?php
$pageTitle = "Page Name";
ob_start();
?>
<h2>Search Tasks</h2>

<form method="get">
    <input type="hidden" name="action" value="search">
    Keyword: <input type="text" name="term" value="<?= htmlspecialchars($term) ?>"><br>

    Category:
    <select name="category">
        <option value="">-- All --</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>" <?= ($categoryId == $cat['id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    Priority:
    <select name="priority">
        <option value="">-- All --</option>
        <?php foreach (['low', 'medium', 'high'] as $p): ?>
            <option value="<?= $p ?>" <?= ($priority == $p) ? 'selected' : '' ?>><?= ucfirst($p) ?></option>
        <?php endforeach; ?>
    </select><br>

    Status:
    <select name="status">
        <option value="">-- All --</option>
        <?php foreach (['todo', 'in_progress', 'done'] as $s): ?>
            <option value="<?= $s ?>" <?= ($status == $s) ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $s)) ?></option>
        <?php endforeach; ?>
    </select><br>

    <input type="submit" value="Search">
</form>

<hr>

<?php if ($term && empty($results)): ?>
    <p>No tasks found matching "<?= htmlspecialchars($term) ?>"</p>
<?php endif; ?>

<?php if (!empty($results)): ?>
    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Category</th>
            <th>Priority</th>
            <th>Status</th>
            <th>Due Date</th>
        </tr>
        <?php foreach ($results as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= nl2br(htmlspecialchars($task['description'])) ?></td>
                <td><?= htmlspecialchars($task['category_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($task['priority']) ?></td>
                <td><?= htmlspecialchars($task['status']) ?></td>
                <td><?= $task['due_date'] ? date('Y-m-d H:i', strtotime($task['due_date'])) : '-' ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<p><a href="index.php?action=tasks">Back to Task List</a></p>
<?php
$content = ob_get_clean();
include 'layout.php';
?>