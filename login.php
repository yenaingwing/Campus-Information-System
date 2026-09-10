<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';

if ($auth->check()) redirect('adminpage.php');
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim((string)($_POST['username'] ?? ''));
    $password = (string)($_POST['password'] ?? '');
    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } elseif ($auth->login($username, $password)) {
        redirect('adminpage.php');
    } else {
        $error = 'Invalid username or password.';
    }
}

$pageTitle = 'Admin Login';
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= e($pageTitle) ?></title><link rel="stylesheet" href="s.css"></head><body>
<div class="login-page"><form action="login.php" method="post" class="login-card"><h1>Admin Login</h1><?php if($error): ?><div class="login-error"><?= e($error) ?></div><?php endif; ?><label>Username<input name="username" autocomplete="username" required></label><label>Password<input type="password" name="password" autocomplete="current-password" required></label><button type="submit">Login</button><a href="index.html">Back to website</a></form></div></body></html>
