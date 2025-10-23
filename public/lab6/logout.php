<?php
include 'config.php';

// Знищення всіх даних сесії
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

session_destroy();

// Перенаправлення на сторінку авторизації
header("Location: login.php");
mysqli_close($conn);
exit();
?>