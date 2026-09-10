<?php
if (!isset($pageTitle)) $pageTitle = 'UCSM Admin';
$flashes = consume_flash();
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?></title>
<link rel="preconnect" href="https://cdn.jsdelivr.net">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
<div class="admin-shell">
<?php require __DIR__ . '/admin_sidebar.php'; ?>
<main class="admin-main">
<div class="admin-topbar">
<button class="sidebar-toggle" type="button" aria-label="Open menu"><i class="fa-solid fa-bars"></i></button>
<div><h1><?= e($pageTitle) ?></h1><p>UCSM Campus Navigation and Information System</p></div>
<a class="btn btn-outline-danger" href="logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
</div>
<?php foreach ($flashes as $flash): ?>
<div class="alert alert-<?= e($flash['type']) ?> alert-dismissible fade show" role="alert">
<?= e($flash['message']) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
<?php endforeach; ?>
