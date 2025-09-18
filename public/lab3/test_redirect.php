<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Перевіряємо, чи не знаходимось ми вже на сторінці перенаправлення
    if (basename($_SERVER['PHP_SELF']) !== 'redirect.php') {
        // Перевіряємо, чи не було вже перенаправлення
        if (!isset($_GET['redirected'])) {
            header('Location: redirect.php?redirected=1');
            exit;
        }
    }
}