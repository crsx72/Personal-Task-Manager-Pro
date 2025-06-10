<?php
$pageTitle = "Page Name";
ob_start();
?>
<?php
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = User::login($_POST['username'], $_POST['password']);
    if ($userId) {
        $_SESSION['user_id'] = $userId;
        header("Location: index.php?action=tasks");
        exit;
    } else {
        $error = "Invalid login.";
    }
}
?>

<h2>Login</h2>
<form method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
    <a href="index.php?action=register">Register</a>
</form>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php
$content = ob_get_clean();
include 'layout.php';
?>