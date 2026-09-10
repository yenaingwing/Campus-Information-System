<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/classes/Database.php';
require_once __DIR__ . '/classes/Building.php';
require_once __DIR__ . '/classes/Room.php';
require_once __DIR__ . '/classes/Department.php';
require_once __DIR__ . '/classes/Search.php';
require_once __DIR__ . '/classes/Auth.php';

$db = Database::getInstance()->connection();
$buildingModel = new Building($db);
$roomModel = new Room($db);
$departmentModel = new Department($db);
$searchModel = new Search($db);
$auth = new Auth($db);
