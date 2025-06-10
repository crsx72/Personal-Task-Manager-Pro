<?php
$pageTitle = "Page Name";
ob_start();
?>
<h2>Your Tasks</h2>

<p>
    <a href="index.php?action=add_task">Add Task</a> |
    <a href="index.php?action=category_list">Add Category</a> |
    <a href="index.php?action=search">Search Tasks</a> |
    <a href="index.php?action=report">View Report</a> |
    <a href="index.php?action=logout">Logout</a>
</p>

<p>
    Sort:
    <a href="index.php?action=tasks&sort=priority">Priority</a> |
    <a href="index.php?action=tasks&sort=due_date">Due Date</a> |
    <a href="index.php?action=tasks&sort=status">Status</a>
</p>

<table border="1" cellpadding="5" cellspacing="0">
    <thead>
    <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Category</th>
        <th>Priority</th>
        <th>Due Date</th>
        <th>Status</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (empty($tasks)): ?>
        <tr>
            <td colspan="7">No tasks found.</td>
        </tr>
    <?php else: ?>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= nl2br(htmlspecialchars($task['description'])) ?></td>
                <td><?= htmlspecialchars($task['category_name'] ?? '-') ?></td>
                <td><?= htmlspecialchars($task['priority']) ?></td>
                <td><?= $task['due_date'] ? date('Y-m-d H:i', strtotime($task['due_date'])) : '-' ?></td>
                <td>
                    <?= htmlspecialchars($task['status']) ?><br>
                    <small>
                        <a href="index.php?action=setStatus&id=<?= $task['id'] ?>&status=todo">Todo</a> |
                        <a href="index.php?action=setStatus&id=<?= $task['id'] ?>&status=in_progress">In Progress</a> |
                        <a href="index.php?action=setStatus&id=<?= $task['id'] ?>&status=done">Done</a>
                    </small>
                </td>
                <td>
                    <a href="index.php?action=edit_task&id=<?= $task['id'] ?>">Edit</a> |
                    <a href="index.php?action=delete_task&id=<?= $task['id'] ?>" onclick="return confirm('Delete this task?')">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
    </tbody>
</table>
<?php
$content = ob_get_clean();
include 'layout.php';
?>