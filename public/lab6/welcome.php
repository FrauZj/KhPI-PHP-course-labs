<?php
include 'config.php';

// Перевірка чи користувач авторизований
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ласкаво просимо</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .welcome-container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        .user-info {
            background-color: #e9ecef;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .logout-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
        }
        .logout-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Ласкаво просимо!</h1>
        
        <div class="user-info">
            <p><strong>Ім'я користувача:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
            <p><strong>ID користувача:</strong> <?php echo $_SESSION['user_id']; ?></p>
        </div>
        
        <p>Ви успішно авторизувалися в системі.</p>
        <p>Ця сторінка доступна тільки для авторизованих користувачів.</p>
        
        <a href="logout.php" class="logout-btn">Вийти</a>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>