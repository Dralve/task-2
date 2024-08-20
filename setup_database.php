<?php
require_once 'Database.php';

$db = new Database();
$pdo = $db->getConnection();

$sqlFile = 'create_table.sql';
$db->executeScript($sqlFile);
?>
