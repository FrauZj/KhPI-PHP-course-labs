<?php

$uploadDir = 'uploads/';
$allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
$maxSize = 2 * 1024 * 1024; // 2 МБ

// Створюємо папку uploads, якщо її немає
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $file = $_FILES['fileToUpload'];
    $fileName = basename($file['name']);
    $fileType = $file['type'];
    $fileSize = $file['size'];
    $fileTmp = $file['tmp_name'];
    $fileError = $file['error'];

    // Перевірка на помилки завантаження
    if ($fileError !== UPLOAD_ERR_OK) {
        die("Помилка при завантаженні файлу: $fileError");
    }

    // Перевірка, чи файл був завантажений через HTTP POST
    if (!is_uploaded_file($fileTmp)) {
        die("Файл не був завантажений через HTTP POST");
    }

    // Перевірка типу файлу
    if (!in_array($fileType, $allowedTypes)) {
        die("Помилка: Дозволені лише файли зображень (PNG, JPG, JPEG)");
    }

    // Перевірка розміру файлу
    if ($fileSize > $maxSize) {
        die("Помилка: Файл занадто великий. Максимальний розмір: 2 МБ");
    }

    // Обробка дублікатів імен файлів
    $originalName = pathinfo($fileName, PATHINFO_FILENAME);
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    $counter = 1;
    $newFileName = $fileName;

    while (file_exists($uploadDir . $newFileName)) {
        $newFileName = $originalName . '_' . $counter . '.' . $extension;
        $counter++;
    }

    // Переміщення файлу в цільову директорію
    $targetPath = $uploadDir . $newFileName;

    if (move_uploaded_file($fileTmp, $targetPath)) {
        echo "<div class='success'>Файл успішно завантажений!</div>";

        echo "<h2>Інформація про файл:</h2>";
        echo "<p><strong>Ім'я файлу:</strong> " . htmlspecialchars($newFileName) . "</p>";
        echo "<p><strong>Тип файлу:</strong> " . htmlspecialchars($fileType) . "</p>";
        echo "<p><strong>Розмір файлу:</strong> " . round($fileSize / 1024, 2) . " КБ</p>";

        echo "<p><strong>Посилання для завантаження:</strong> ";
        echo "<a href='" . htmlspecialchars($targetPath) . "' download>Завантажити файл</a></p>";

        echo "<p><a href='index.html'>На головну</a> | <a href='list.php'>Переглянути всі файли</a></p>";
    } else {
        echo "<div class='error'>Помилка при збереженні файлу.</div>";
        echo "<p><a href='index.html'>Спробувати ще раз</a></p>";
    }
} else {
    header("Location: index.html");
    exit();
}
