<?php

$uploadDir = 'uploads/';

// Створюємо папку uploads, якщо її немає
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

echo "<h2>Список файлів у папці uploads</h2>";

$files = scandir($uploadDir);
$fileCount = 0;


foreach ($files as $file) {
    if ($file !== '.' && $file !== '..') {
        $filePath = $uploadDir . $file;
        $fileSize = filesize($filePath);
        $fileType = mime_content_type($filePath);

        echo "<tr>";
        echo "<td>" . htmlspecialchars($file) . "<br></td>";
        echo "<td>" . round($fileSize / 1024, 2) . " КБ<br></td>";
        echo "<td>" . htmlspecialchars($fileType) . "\n</td>";
        echo "<td><a href='" . htmlspecialchars($filePath) . "' download>Завантажити<br><br></a></td>";
        echo "</tr>";

        $fileCount++;
    }
}

echo "</table>";

if ($fileCount === 0) {
    echo "<p>У папці немає файлів.</p>";
} else {
    echo "<p>Всього файлів: $fileCount</p>";
}

echo "<p><a href='index.html'>На головну</a> | <a href='text.php'>Переглянути log.txt</a></p>";
