<?php
declare(strict_types=1); require __DIR__.'/includes/auth_guard.php';
$errors=[]; $name=''; $description='';
if($_SERVER['REQUEST_METHOD']==='POST'){if(!verify_csrf($_POST['csrf_token']??null)){$errors[]='Invalid form token. Please try again.';}

  $name=trim((string)($_POST['bname']??'')); $description=trim((string)($_POST['description']??''));
  if($name==='') $errors[]='Building name is required.';
  if(!$errors){try{$image=image_upload(); if(!$image) throw new RuntimeException('Please choose an image.'); $buildingModel->create($name,$image,$description); flash('success','Building created successfully.'); redirect('adminpage.php');}catch(Throwable $e){error_log($e->getMessage()); if(isset($image)) delete_uploaded_image($image); $errors[]='The building could not be created. Please check your input and try again.';}}
}
$pageTitle='Add Building'; require __DIR__.'/includes/admin_header.php';
?><div class="admin-card form-card"><form method="post" enctype="multipart/form-data"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><?php foreach($errors as $error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endforeach; ?><div class="mb-3"><label class="form-label">Building name</label><input class="form-control" name="bname" value="<?=e($name)?>" required maxlength="200"></div><div class="mb-3"><label class="form-label">Image</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/gif,image/webp" required></div><div class="mb-3"><label class="form-label">Description</label><textarea class="form-control" name="description" rows="7"><?=e($description)?></textarea></div><button class="btn btn-success">Save</button> <a class="btn btn-secondary" href="adminpage.php">Cancel</a></form></div><?php require __DIR__.'/includes/admin_footer.php'; ?>
