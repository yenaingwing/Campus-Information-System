<?php
declare(strict_types=1);
require_once __DIR__ . '/../bootstrap.php';

if (!$auth->check()) {
    flash('warning', 'Please sign in to access the admin dashboard.');
    redirect('login_form.php');
}
