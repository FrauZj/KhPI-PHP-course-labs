<?php
include 'config.php';
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна сторінка</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
            text-align: center;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-bottom: 30px;
        }
        .btn {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
        }
        .login-btn {
            background-color: #28a745;
            color: white;
        }
        .register-btn {
            background-color: #007bff;
            color: white;
        }
        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Система авторизації</h1>  
        <div>
            <a href="login.php" class="btn login-btn">Увійти</a>
            <a href="register.php" class="btn register-btn">Зареєструватися</a>
        </div>
        
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <div style="margin-top: 30px;">
                <p>Ви вже авторизовані як: <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></p>
                <a href="welcome.php" class="btn" style="background-color: #6c757d; color: white;">Перейти до кабінету</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
<?php
mysqli_close($conn);
?>