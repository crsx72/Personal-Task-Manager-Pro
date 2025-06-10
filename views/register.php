<?php
$pageTitle = "Page Name";
ob_start();
?>
<?php
require_once '../models/User.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (strlen($username) < 3 || strlen($username) > 50) {
        $error = "Username must be 3–50 characters.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } elseif (!User::register($username, $email, $password)) {
        $error = "Username or email already exists.";
    } else {
        header("Location: index.php?action=login");
        exit;
    }
}
?>

<h2>Register</h2>
<form method="post">
    Username: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input type="submit" value="Register">
    <a href="index.php?action=login">Login</a>
</form>
<p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php
$content = ob_get_clean();
include 'layout.php';
?>