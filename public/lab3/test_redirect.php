<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    if (basename($_SERVER['PHP_SELF']) !== 'redirect.php') {
        if (!isset($_GET['redirected'])) {
            header('Location: redirect.php?redirected=1');
            exit;
        }
    }
}