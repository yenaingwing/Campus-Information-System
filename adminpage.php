<?php
declare(strict_types=1);
require __DIR__ . '/includes/auth_guard.php';
try { $buildings = $buildingModel->all(); } catch(Throwable $e){ error_log($e->getMessage()); flash('danger','Buildings could not be loaded.'); $buildings=[]; }
$pageTitle='Buildings'; require __DIR__.'/includes/admin_header.php';
?>
<div class="admin-card"><div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3"><h2 class="h4 mb-0">Buildings</h2><a class="btn btn-primary" href="add-new.php"><i class="fa-solid fa-plus"></i> Add Building</a></div>
<div class="table-wrap"><table class="table table-hover admin-table"><thead class="table-dark"><tr><th>ID</th><th>Name</th><th>Image</th><th>Description</th><th>Actions</th></tr></thead><tbody>
<?php if(!$buildings): ?><tr><td colspan="5" class="empty-state">No buildings found.</td></tr><?php endif; ?>
<?php foreach($buildings as $row): ?><tr><td><?= (int)$row['id'] ?></td><td><?= e($row['bname']) ?></td><td><?php if($row['img']): ?><img src="<?= e($row['img']) ?>" alt="<?= e($row['bname']) ?>"><?php endif; ?></td><td><?= nl2br(e($row['description'])) ?></td><td class="text-nowrap"><a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= (int)$row['id'] ?>">Edit</a> <form class="d-inline" action="delete.php" method="post" onsubmit="return confirm('Delete this building and its associated rooms and departments?');"><input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>"><input type="hidden" name="id" value="<?= (int)$row['id'] ?>"><button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr><?php endforeach; ?>
</tbody></table></div></div><?php require __DIR__.'/includes/admin_footer.php'; ?>
