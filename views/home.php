<?php
$pageTitle = "Page Name";
ob_start();
?>
<h2>Welcome to Personal Task Manager Pro</h2>

<p>This app helps you organize tasks, track progress, and stay productive.</p>

<ul>
    <li><a href="index.php?action=login">Login</a></li>
    <li><a href="index.php?action=register">Register</a></li>
</ul>
<?php
$content = ob_get_clean();
include 'layout.php';
?>