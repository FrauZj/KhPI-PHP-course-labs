<?php
session_start();

$host = 'mysql'; 
$username = 'started-user'; 
$password = 'started-password'; 
$database = 'started';

$conn = mysqli_connect($host, $username, $password);

if ($conn->connect_error) {
    die("Помилка підключення до MySQL: " . $conn->connect_error);
}

// Створення бази даних, якщо вона не існує
$create_db_query = "CREATE DATABASE IF NOT EXISTS $database";
if (!$conn->query($create_db_query)) {
    die("Помилка створення бази даних: " . $conn->error);
}

// Вибір бази даних
$conn->select_db($database);

// Створення таблиці users, якщо вона не існує
$create_table_query = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if (!$conn->query($create_table_query)) {
    die("Помилка створення таблиці: " . $conn->error);
}

$conn->set_charset("utf8");

function backupDatabase($conn, $database) {
    $backup_file = 'dump.sql';
    
    // Отримуємо всі таблиці з бази даних
    $tables = array();
    $result = $conn->query("SHOW TABLES");
    while ($row = $result->fetch_row()) {
        $tables[] = $row[0];
    }
    
    $backup_content = "-- Дамп бази даних `$database`\n";
    $backup_content .= "-- Створено: " . date('Y-m-d H:i:s') . "\n\n";
    
    foreach ($tables as $table) {
        $backup_content .= "--\n-- Структура таблиці `$table`\n--\n";
        $backup_content .= "DROP TABLE IF EXISTS `$table`;\n";
        
        $create_table = $conn->query("SHOW CREATE TABLE `$table`");
        $row = $create_table->fetch_row();
        $backup_content .= $row[1] . ";\n\n";
        
        $backup_content .= "--\n-- Дамп даних таблиці `$table`\n--\n";
        
        $result = $conn->query("SELECT * FROM `$table`");
        if ($result->num_rows > 0) {
            $backup_content .= "INSERT INTO `$table` VALUES ";
            $rows = array();
            while ($row = $result->fetch_row()) {
                $values = array_map(function($value) use ($conn) {
                    if ($value === null) return 'NULL';
                    return "'" . $conn->real_escape_string($value) . "'";
                }, $row);
                $rows[] = "(" . implode(', ', $values) . ")";
            }
            $backup_content .= implode(",\n", $rows) . ";\n\n";
        }
    }
    
    file_put_contents($backup_file, $backup_content);
}

backupDatabase($conn, $database);
?>