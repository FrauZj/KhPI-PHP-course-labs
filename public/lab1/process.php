<?php

echo "<!DOCTYPE html>
<html lang='uk'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Результат обробки</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .result-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .success {
            color: #28a745;
            font-weight: bold;
        }
        .error {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class='result-container'>";

// Перевірка, чи форма була відправлена методом POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Отримання даних з форми
    $firstName = isset($_POST['first_name']) ? $_POST['first_name'] : '';
    $lastName = isset($_POST['last_name']) ? $_POST['last_name'] : '';

    // Перевірка на пусті значення
    if (empty($firstName) || empty($lastName)) {
        echo "<h2 class='error'>Помилка!</h2>";
        echo "<p>Будь ласка, заповніть всі обов'язкові поля.</p>";
    }
    // Перевірка типів даних
    elseif (!preg_match("/^[a-zA-Zа-яА-ЯїЇіІєЄґҐ\s\-']+$/u", $firstName) ||
        !preg_match("/^[a-zA-Zа-яА-ЯїЇіІєЄґҐ\s\-']+$/u", $lastName)) {
        echo "<h2 class='error'>Помилка!</h2>";
        echo "<p>Ім'я та прізвище повинні містити лише літери.</p>";
    }
    // Успішна обробка даних
    else {
        // Екранування спеціальних символів для безпеки
        $safeFirstName = htmlspecialchars($firstName, ENT_QUOTES, 'UTF-8');
        $safeLastName = htmlspecialchars($lastName, ENT_QUOTES, 'UTF-8');

        echo "<h2 class='success'>Вітаємо!</h2>";
        echo "<p>Привіт, <strong>" . $safeFirstName . " " . $safeLastName . "</strong>!</p>";
        echo "<p>Ваші дані успішно оброблено.</p>";
    }
} else {
    echo "<h2 class='error'>Помилка доступу</h2>";
    echo "<p>Ця сторінка доступна лише після відправки форми.</p>";
}

echo "    </div>
</body>
</html>";
?>