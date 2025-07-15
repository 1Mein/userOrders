<?php

require 'src/db.php';
require_once 'src/connection.php';


/** @var $pdo */
$users = getUsers($pdo,30, 0);

echo '<pre>';
print_r($users);
echo '</pre>';