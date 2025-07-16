<?php

require 'src/db.php';
require_once 'src/connection.php';

$limitDay = isset($_GET['limit_day']) ? (int)$_GET['limit_day'] : null;
$minAmount = isset($_GET['min_amount']) ? (float)$_GET['min_amount'] : 0;

$searchName = isset($_GET['search_name']) ? (float)$_GET['search_name'] : 0;

/** @var $pdo */
$users = getUsers($pdo,$limitDay, $minAmount, $searchName);

echo '<pre>';
print_r($users);
echo '</pre>';