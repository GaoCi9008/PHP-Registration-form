<?php


$host = 'localhost';      // MySQL 服务器 IP
$dbname = 'job_db';           // 数据库名
$username = 'root';           // 用户名
$password = '123456';         // 密码

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("数据库连接失败: " . $e->getMessage());
}
