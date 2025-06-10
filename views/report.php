<?php
$pageTitle = "Page Name";
ob_start();
?>
<h2>Task Report</h2>

<p><strong>Status Summary:</strong></p>
<ul>
    <li>Todo: <?= $statusCounts['todo'] ?? 0 ?></li>
    <li>In Progress: <?= $statusCounts['in_progress'] ?? 0 ?></li>
    <li>Done: <?= $statusCounts['done'] ?? 0 ?></li>
</ul>

<p><strong>Overdue Tasks:</strong> <?= $overdueCount ?></p>

<p><strong>Category Summary:</strong></p>
<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Category</th>
        <th>Total Tasks</th>
        <th>Done</th>
    </tr>
    <?php foreach ($categorySummary as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= $row['total'] ?></td>
            <td><?= $row['done'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<p><a href="index.php?action=tasks">Back to Task List</a></p>
<?php
$content = ob_get_clean();
include 'layout.php';
?>