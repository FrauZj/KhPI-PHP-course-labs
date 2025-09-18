<?php
// redirect.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сторінка перенаправлення</title>
</head>
<body>
<h1>Це сторінка перенаправлення</h1>
<p>Ви були перенаправлені, оскільки метод запиту не був POST.</p>
<p><a href="index.php">Повернутися на головну</a></p>
</body>
</html>