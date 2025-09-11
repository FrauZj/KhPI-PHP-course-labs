<?php
$uploadDir = 'uploads/';
$logFile = $uploadDir . 'log.txt';

// Створюємо папку uploads, якщо її немає
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['textContent'])) {
    $text = $_POST['textContent'];
    $timestamp = date('Y-m-d H:i:s');

    // Форматуємо запис з timestamp
    $logEntry = "[" . $timestamp . "]\n" . $text . "\n" . str_repeat("-", 50) . "\n";

    // Записуємо у файл (додаємо в кінець)
    if (file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX)) {
        echo "<div class='success'>Текст успішно записано у файл!</div>";
    } else {
        echo "<div class='error'>Помилка при записі у файл.</div>";
    }
}

// Читання та виведення вмісту файлу
echo "<h2>Вміст файлу log.txt</h2>";

if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    if (!empty($content)) {
        echo "<pre>" . htmlspecialchars($content) . "</pre>";
    } else {
        echo "<p>Файл порожній.</p>";
    }
} else {
    echo "<p>Файл log.txt ще не створено.</p>";
}

echo "<p><a href='index.html'>На головну</a> | <a href='list.php'>Переглянути всі файли</a></p>";
?>