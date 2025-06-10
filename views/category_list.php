<?php
$pageTitle = "Page Name";
ob_start();
?>
<h2>Your Categories</h2>
<ul>
    <?php foreach ($categories as $cat): ?>
        <li><?= htmlspecialchars($cat['name']) ?></li>
    <?php endforeach; ?>
</ul>
<a href="index.php?action=add_category">Add Category</a> |
<a href="index.php?action=tasks">Return to tasks</a>
<?php
$content = ob_get_clean();
include 'layout.php';
?>