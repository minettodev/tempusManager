<?php
global $_pdo;
$_DATABASE = [
    'USER' => 'root',
    'PASSWORD' => '',
    'HOST' => 'localhost',
    'DATABASE' => 'db'
];
global $_DATABASE;
try {
    $_pdo = new PDO("mysql:host=" . $_DATABASE["HOST"] . ";dbname=" . $_DATABASE["DATABASE"], $_DATABASE["USER"], $_DATABASE["PASSWORD"]);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
