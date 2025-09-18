<?php
session_start();
$_SESSION['last_activity'] = time();
echo 'Activity updated: ' . date('H:i:s');
?>