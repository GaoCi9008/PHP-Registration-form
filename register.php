<?php
// register.php - 只处理注册逻辑，不输出任何HTML

require 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // 如果不是POST请求，直接重定向回首页
    header('Location: index.php');
    exit;
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

// 验证输入
if (empty($username) || empty($email) || empty($password)) {
    $error = '所有字段都必须填写';
} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = '邮箱格式不正确';
} elseif (strlen($password) < 6) {
    $error =  '密码至少需要6位';
} elseif ($password !== $confirm_password) {
    $error = '两次密码输入不一致';
} else {
    try {
        // 检查用户名/邮箱是否已存在
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");      //查询用户表，检查是否有相同的用户名或邮箱，？表示占位符，防止SQL注入
        $stmt->execute([$username, $email]);                                                //执行查询，传入用户名和邮箱作为参数
        if ($stmt->fetch()) {                                                                  // 如果查询结果存在，说明用户名或邮箱已被注册
            $error = '用户名或邮箱已被注册';                                                    
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);                    // 使用PHP内置的密码哈希函数来安全地存储密码
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");       // 准备插入新用户的SQL语句
            $stmt->execute([$username, $email, $password_hash]);            // 执行插入操作，传入用户名、邮箱和密码哈希作为参数
            // 注册成功，重定向到首页并附带成功标志
            header('Location: index.php?success=1');        
            exit;
        }
    } catch (PDOException $e) {         
        $error = '系统错误，请稍后重试';
        // 可记录日志：error_log($e->getMessage());
    }
}

// 如果有错误，重定向回首页并附带错误信息和已填写的用户名/邮箱
$params = [
    'error' => $error,
    'username' => $username,
    'email' => $email
];
header('Location: index.php?' . http_build_query($params));
exit;
