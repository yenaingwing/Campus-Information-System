<?php
declare(strict_types=1);
$allowed = ['index.html','info.html','map.html','aboutus.php','maledormitory.html','femaledormitory.html','parkingplace.html','sporthall.html','laboratory.html','mainbuild.html','canteen1.html','female.html','ma.html'];
$destination = basename((string)($_GET['dormitory'] ?? ''));
header('Location: ' . (in_array($destination, $allowed, true) ? $destination : 'index.html'));
exit;
