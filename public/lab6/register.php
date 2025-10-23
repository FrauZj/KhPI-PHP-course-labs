<?php
include 'config.php';

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Валідація даних
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Всі поля обов'язкові для заповнення!";
    } elseif ($password !== $confirm_password) {
        $error = "Паролі не співпадають!";
    } elseif (strlen($password) < 6) {
        $error = "Пароль повинен містити щонайменше 6 символів!";
    } else {
        $check_query = "SELECT id FROM users WHERE username = '" .
         mysqli_real_escape_string($conn, $username) . 
         "' OR email = '" . 
         mysqli_real_escape_string($conn, $email) .
          "'";
        $result = mysqli_query($conn, $check_query);

    if (!$result) {
        $error = "Помилка перевірки користувача: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            $error = "Користувач з таким іменем або email вже існує!";
        } else {
                    mysqli_free_result($result);

                    $hashed_password = md5($password);

                    $insert_query = "INSERT INTO users (username, email, password) VALUES ('" .
                                    mysqli_real_escape_string($conn, $username) . "', '" .
                                    mysqli_real_escape_string($conn, $email) . "', '" .
                                    $hashed_password . "')";
                    if (mysqli_query($conn, $insert_query)) {
                        $success = "Реєстрація успішна! Тепер ви можете увійти.";
                        backupDatabase($conn, $database);
                    } else {
                        $error = "Помилка реєстрації: " . mysqli_error($conn);
                    }

                }
            }
    }
}
?>


<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Реєстрація</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: #dc3545;
            background-color: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .success {
            color: #155724;
            background-color: #d4edda;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .login-link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Реєстрація</h2>
        
        <?php if (!empty($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if (!empty($success)): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Ім'я користувача:</label>
                <input type="text" id="username" name="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Підтвердження пароля:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit">Зареєструватися</button>
        </form>
        
        <div class="login-link">
            <p>Вже маєте акаунт? <a href="login.php">Увійти</a></p>
        </div>
    </div>
</body>
</html>