<?php
header('Content-Type: application/json');

// 資料庫配置
$host = "localhost";
$dbname = "huang_xiang";
$username = "root";
$password = "";

try {
    // 使用 PDO 連接資料庫，防止 SQL 注入
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    
    // 獲取 POST 數據
    $data = json_decode(file_get_contents('php://input'), true);
    $emp_no = $data['emp_no'] ?? '';
    $user_pass = $data['password'] ?? '';

    // 查詢資料庫
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE emp_no = :emp_no AND password = :password");
    $stmt->execute(['emp_no' => $emp_no, 'password' => $user_pass]);
    $user = $stmt->fetch();

    if ($user) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => '帳號或密碼錯誤']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => '資料庫連接失敗: ' . $e->getMessage()]);
}
?>