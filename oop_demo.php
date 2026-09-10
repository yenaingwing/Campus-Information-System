<?php
declare(strict_types=1);
require_once __DIR__ . '/bootstrap.php';
$buildings = $buildingModel->all();
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>OOP Demo</title></head>
<body>
<h1>OOP Database Demo</h1>
<p>This page gets buildings through the <code>Building</code> class.</p>
<ul>
<?php while ($building = $buildings->fetch_assoc()): ?>
<li><?= htmlspecialchars((string)$building['bname']) ?></li>
<?php endwhile; ?>
</ul>
<p><a href="adminpage.php">Back to admin page</a></p>
</body></html>
