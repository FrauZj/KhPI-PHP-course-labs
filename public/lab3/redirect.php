<?php
session_start();

if (isset($_GET['redirected'])) {
    $message = "Ви були перенаправлені, оскільки метод запиту не був POST.";
} else {
    header('Location: redirect.php?redirected=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сторінка перенаправлення</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .message { background: #e7f3fe; padding: 20px; border-left: 4px solid #2196F3; }
        .back-button {
            background: #337ab7;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
            margin: 20px 0;
        }
    </style>
</head>
<body>
<h1>Сторінка перенаправлення</h1>

<div class="message">
    <p><?php echo $message; ?></p>
    <p><strong>Метод запиту:</strong> <?php echo $_SERVER['REQUEST_METHOD']; ?></p>
    <p><strong>Поточний файл:</strong> <?php echo $_SERVER['PHP_SELF']; ?></p>
</div>

<p>Ця сторінка демонструє роботу механізму автоматичного перенаправлення при використанні методу, відмінного від POST.</p>

<a href="index.php" class="back-button">Повернутися на головну</a>
<br>
</body>
</html>