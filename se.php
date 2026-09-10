<?php
declare(strict_types=1);
require __DIR__ . '/bootstrap.php';

$term = trim((string)($_GET['q'] ?? $_POST['a'] ?? ''));
$error = null;
$results = ['buildings' => [], 'rooms' => [], 'departments' => []];

if ($term !== '') {
    try {
        $results = $searchModel->search($term);
    } catch (Throwable $e) {
        error_log('Search error: ' . $e->getMessage());
        $error = 'The search service is temporarily unavailable. Please try again later.';
    }
}

$total = count($results['buildings']) + count($results['rooms']) + count($results['departments']);
function imageUrl(?string $path): string {
    $path = trim((string)$path);
    if ($path === '') return '';
    if (preg_match('#^https?://#i', $path)) return $path;
    $path = str_replace('\\', '/', $path);
    return ltrim($path, '/');
}
?>
<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Search Results | UCSM</title>
<link rel="stylesheet" href="nav.css">
<link rel="stylesheet" href="footer.css">
<link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
<style>
body{margin:0;padding-top:70px;background:var(--page-bg);color:var(--page-text);font-family:'Poppins',system-ui,sans-serif;min-height:100vh}.results-wrap{width:min(1100px,calc(100% - 28px));margin:30px auto 50px}.results-title{margin:0 0 8px;font-size:clamp(1.6rem,3vw,2.2rem)}.results-subtitle{margin:0 0 24px;color:#6b7280}.dark .results-subtitle{color:#cbd5e1}.message{padding:20px;border-radius:12px;margin-bottom:22px;border:1px solid var(--border);background:var(--panel-bg)}.message.error{border-color:#fecaca;background:#fef2f2;color:#991b1b}.message.warning{border-color:#fde68a;background:#fffbeb;color:#92400e}.message.success{border-color:#bbf7d0;background:#f0fdf4;color:#166534}.dark .message.error{background:#3b1f1f;color:#fecaca}.dark .message.warning{background:#3a3219;color:#fde68a}.dark .message.success{background:#183321;color:#bbf7d0}.message h2{margin:0 0 8px;font-size:1.2rem}.message p{line-height:1.6;margin:6px 0}.result-card{display:grid;grid-template-columns:minmax(230px,38%) 1fr;gap:24px;background:var(--panel-bg);border:1px solid var(--border);border-radius:14px;padding:18px;margin:18px 0;box-shadow:0 5px 20px rgba(0,0,0,.06)}.result-card img{display:block;width:100%;height:260px;object-fit:cover;border-radius:10px;background:#e5e7eb}.result-card h2{margin:2px 0 14px;font-size:1.35rem}.result-card h3{margin:9px 0 4px;font-size:1rem}.result-card p{line-height:1.7;margin:12px 0;white-space:pre-line;color:#4b5563}.dark .result-card p{color:#d1d5db}.back{display:inline-block;margin-top:10px;padding:10px 16px;background:#2f1fe4;color:#fff;border-radius:8px;text-decoration:none}.search-again{display:flex;gap:8px;max-width:600px}.search-again input{flex:1;min-width:0;height:42px;border:1px solid var(--border);border-radius:8px;padding:0 12px;background:var(--panel-bg);color:var(--page-text)}.search-again button{border:0;border-radius:8px;padding:0 16px;background:#2f1fe4;color:#fff;cursor:pointer}@media(max-width:700px){body{padding-top:64px}.results-wrap{width:calc(100% - 18px);margin-top:22px}.result-card{grid-template-columns:1fr;gap:16px}.result-card img{height:220px}.search-again{flex-direction:column}.search-again button{height:42px}}
</style>
</head>
<body>
<?php require __DIR__ . '/includes/public_nav.php'; ?>
<main class="results-wrap">
<h1 class="results-title">Search Results</h1>
<p class="results-subtitle">Search by building name, room number, department name, or floor.</p>
<?php if ($term === ''): ?>
<div class="message warning"><h2>Please enter a search term</h2><p>Enter the information you want to find using the search box above.</p></div>
<form class="search-again" action="se.php" method="get"><input type="search" name="q" placeholder="Search campus information" required><button type="submit">Search</button></form>
<?php elseif ($error): ?>
<div class="message error"><h2>Search error</h2><p><?= e($error) ?></p></div>
<?php elseif ($total === 0): ?>
<div class="message warning"><h2>No results found</h2><p>No result was found for <strong><?= e($term) ?></strong>.</p><p>Building searches use the building name only. Building descriptions are not searched.</p></div>
<form class="search-again" action="se.php" method="get"><input type="search" name="q" value="<?= e($term) ?>" required><button type="submit">Search Again</button></form>
<?php else: ?>
<div class="message success"><h2>Results found</h2><p>Found <?= $total ?> result(s) for <strong><?= e($term) ?></strong>.</p></div>
<?php foreach ($results['buildings'] as $r): ?>
<article class="result-card">
<?php $img=imageUrl($r['image'] ?? ''); if ($img !== ''): ?><img src="<?= e($img) ?>" alt="<?= e($r['building_name'] ?? 'Building') ?>" loading="lazy"><?php endif; ?>
<div><h2>Building — <?= e($r['building_name'] ?? '') ?></h2><p><?= e($r['building_description'] ?? '') ?></p></div>
</article>
<?php endforeach; ?>
<?php foreach ($results['rooms'] as $r): ?>
<article class="result-card">
<?php $img=imageUrl($r['imageroom'] ?? ''); if ($img !== ''): ?><img src="<?= e($img) ?>" alt="Room <?= e($r['roomnumber'] ?? '') ?>" loading="lazy"><?php endif; ?>
<div><h2>Room <?= e($r['roomnumber'] ?? '') ?></h2><h3>Building — <?= e($r['building_name'] ?? '') ?></h3><h3>Floor — <?= e($r['floornumber'] ?? '') ?></h3><p><?= e($r['room_description'] ?? '') ?></p></div>
</article>
<?php endforeach; ?>
<?php foreach ($results['departments'] as $r): ?>
<article class="result-card">
<?php $img=imageUrl($r['imagedepartment'] ?? ''); if ($img !== ''): ?><img src="<?= e($img) ?>" alt="<?= e($r['departmentname'] ?? 'Department') ?>" loading="lazy"><?php endif; ?>
<div><h2><?= e($r['departmentname'] ?? '') ?></h2><h3>Building — <?= e($r['building_name'] ?? '') ?></h3><h3>Room — <?= e($r['roomnum'] ?? '') ?></h3><h3>Floor — <?= e($r['floors'] ?? '') ?></h3><p><?= e($r['department_description'] ?? '') ?></p></div>
</article>
<?php endforeach; ?>
<?php endif; ?>
</main>
<script src="script.js"></script>
</body>
</html>
