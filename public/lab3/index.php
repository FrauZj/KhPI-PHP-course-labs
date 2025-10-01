<?php
session_start();

if (isset($_POST['show_redirect_code'])) {
    header('Location: test_redirect.php');
    exit;
}
const InactivityTime = 300;

$session_expired = false;
if (isset($_SESSION['last_activity'])) {
    if (time() - $_SESSION['last_activity'] > InactivityTime) {
        $session_expired = true;
        session_unset();
        session_destroy();
        session_start();
    }
}


$_SESSION['last_activity'] = time();

if (isset($_GET['reload_after_inactivity'])) {
    header('Location: ' . str_replace('?reload_after_inactivity=1', '', $_SERVER['REQUEST_URI']));
    exit;
}

if (isset($_POST['set_name'])) {
    $username = htmlspecialchars(trim($_POST['username']));
    setcookie('user_name', $username, time() + (7 * 24 * 60 * 60), '/');
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['delete_cookie'])) {
    setcookie('user_name', '', time() - 3600, '/');
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (isset($_POST['login'])) {
    $login = htmlspecialchars(trim($_POST['login']));
    $password = htmlspecialchars(trim($_POST['password']));

    if ($login === 'admin' && $password === 'password') {
        $_SESSION['user'] = [
            'login' => $login,
            'logged_in' => true,
            'last_activity' => time()
        ];
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $login_error = "Невірний логін або пароль";
    }
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if (isset($_POST['add_to_cart'])) {
    $product = htmlspecialchars(trim($_POST['product']));
    if (!empty($product)) {
        $_SESSION['cart'][] = $product;

        $previous_purchases = isset($_COOKIE['previous_purchases']) ?
            json_decode($_COOKIE['previous_purchases'], true) : [];
        $previous_purchases[] = $product;
        setcookie('previous_purchases', json_encode($previous_purchases), time() + (30 * 24 * 60 * 60), '/');
    }
}

if (isset($_POST['clear_cart'])) {
    $_SESSION['cart'] = [];
}


$initial_time_left = InactivityTime - (time() - $_SESSION['last_activity']);
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP Сесії та Cookie</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ccc; border-radius: 5px; }
        .success { color: green; }
        .error { color: red; }

        /* Стилі для повідомлення про неактивність */
        .inactivity-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .inactivity-message {
            background: white;
            padding: 30px;
            border-radius: 10px;
            text-align: center;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
        }

        .inactivity-message h2 {
            color: #d9534f;
            margin-bottom: 15px;
        }

        .reload-button {
            background: #5cb85c;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }

        .reload-button:hover {
            background: #4cae4c;
        }

        .timer {
            font-size: 18px;
            color: #333;
            margin: 10px 0;
        }

        .time-left {
            font-weight: bold;
            color: #d9534f;
        }

        .auto-reload-timer {
            font-size: 14px;
            color: #666;
            margin-top: 10px;
        }
        .redirect-button {
            background: #337ab7;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            margin: 5px;
        }

        .redirect-button:hover {
            background: #286090;
        }
    </style>
</head>
<body>
<?php if ($session_expired): ?>
    <!-- Повідомлення про неактивність -->
    <div class="inactivity-overlay">
        <div class="inactivity-message">
            <h2>Сесія закінчилася через неактивність</h2>
            <p>Ви були неактивні більше 5 хвилин.</p>
            <p class="auto-reload-timer">Автоматичне перезавантаження через: <span id="countdown">10</span> сек.</p>
            <button class="reload-button" onclick="reloadPage()">
                Перезавантажити сторінку
            </button>
        </div>
    </div>

    <script>
        function reloadPage() {
            window.location.href = '<?php echo $_SERVER['PHP_SELF'] . '?reload_after_inactivity=1'; ?>';
        }

        // Автоматичне перезавантаження з відліком
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');

        const countdownInterval = setInterval(function() {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(countdownInterval);
                reloadPage();
            }
        }, 1000);
    </script>
<?php endif; ?>

<h1>Робота з PHP Сесіями та Cookie</h1>
<!-- Кнопка для демонстрації коду перенаправлення -->
<div class="section">
    <h2>Демонстрація механізму перенаправлення</h2>
    <p>Поточий метод запиту: <strong><?php echo $_SERVER['REQUEST_METHOD']; ?></strong></p>
    <form method="post">
        <button type="submit" name="show_redirect_code" class="redirect-button">
            Перенаправлення
        </button>
    </form>
</div>
<!-- Індикатор активності сесії -->
<div class="section">
    <h2>Статус сесії</h2>
    <p>Час останньої активності:
        <strong id="last-activity"><?php echo date('H:i:s', $_SESSION['last_activity']); ?></strong>
    </p>
    <p>Час до автоматичного завершення:
        <strong id="time-left" class="time-left"><?php echo $initial_time_left; ?></strong> секунд
    </p>
    <button onclick="updateActivity()">Оновити активність (тест)</button>
</div>

<!-- Робота з $_COOKIE -->
<div class="section">
    <h2>Робота з Cookie</h2>
    <?php if (isset($_COOKIE['user_name'])): ?>
        <p class="success">Вітаємо, <?php echo htmlspecialchars($_COOKIE['user_name']); ?>! (з Cookie)</p>
        <form method="post">
            <button type="submit" name="delete_cookie">Видалити Cookie</button>
        </form>
    <?php else: ?>
        <form method="post">
            <label for="username">Введіть ваше ім'я:</label>
            <input type="text" id="username" name="username" required>
            <button type="submit" name="set_name">Зберегти в Cookie</button>
        </form>
    <?php endif; ?>
</div>

<!-- Робота з $_SESSION -->
<div class="section">
    <h2>Робота з Сесією</h2>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['logged_in']): ?>
        <p class="success">Вітаємо, <?php echo htmlspecialchars($_SESSION['user']['login']); ?>! Ви увійшли в систему.</p>
        <form method="post">
            <button type="submit" name="logout">Вийти</button>
        </form>
    <?php else: ?>
        <form method="post">
            <div>
                <label for="login">Логін:</label>
                <input type="text" id="login" name="login" required>
            </div>
            <div>
                <label for="password">Пароль:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Увійти</button>
            <?php if (isset($login_error)): ?>
                <p class="error"><?php echo $login_error; ?></p>
            <?php endif; ?>
        </form>
        <p><small>Тестові дані: логін - admin, пароль - password</small></p>
    <?php endif; ?>
</div>

<!-- Корзина покупок -->
<div class="section">
    <h2>Корзина покупок</h2>
    <form method="post">
        <label for="product">Додати товар:</label>
        <input type="text" id="product" name="product" required>
        <button type="submit" name="add_to_cart">Додати в корзину</button>
    </form>

    <h3>Поточна корзина (сесія):</h3>
    <?php if (!empty($_SESSION['cart'])): ?>
        <ul>
            <?php foreach ($_SESSION['cart'] as $index => $product): ?>
                <li><?php echo htmlspecialchars($product); ?></li>
            <?php endforeach; ?>
        </ul>
        <form method="post">
            <button type="submit" name="clear_cart">Очистити корзину</button>
        </form>
    <?php else: ?>
        <p>Корзина порожня</p>
    <?php endif; ?>

    <h3>Попередні покупки (cookie):</h3>
    <?php if (isset($_COOKIE['previous_purchases'])):
        $previous_purchases = json_decode($_COOKIE['previous_purchases'], true);
        ?>
        <ul>
            <?php foreach ($previous_purchases as $product): ?>
                <li><?php echo htmlspecialchars($product); ?></li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Немає попередніх покупок</p>
    <?php endif; ?>
</div>

<!-- Робота з $_SERVER -->
<div class="section">
    <h2>Інформація про сервер</h2>
    <ul>
        <li><strong>IP-адреса клієнта:</strong> <?php echo $_SERVER['REMOTE_ADDR'] ?? 'Невідомо'; ?></li>
        <li><strong>Браузер:</strong> <?php echo $_SERVER['HTTP_USER_AGENT'] ?? 'Невідомо'; ?></li>
        <li><strong>Виконуваний скрипт:</strong> <?php echo $_SERVER['PHP_SELF'] ?? 'Невідомо'; ?></li>
        <li><strong>Метод запиту:</strong> <?php echo $_SERVER['REQUEST_METHOD'] ?? 'Невідомо'; ?></li>
        <li><strong>Шлях до файлу:</strong> <?php echo $_SERVER['SCRIPT_FILENAME'] ?? 'Невідомо'; ?></li>
    </ul>
</div>

<script>

    const InactivityTime = 300;
    // Динамічний таймер
    let timeLeft = <?php echo $initial_time_left; ?>;
    const timeLeftElement = document.getElementById('time-left');
    const lastActivityElement = document.getElementById('last-activity');

    function updateTimer() {
        if (timeLeft > 0) {
            timeLeft--;
            timeLeftElement.textContent = timeLeft;
        } else {
            // Якщо час вийшов, перезавантажуємо сторінку
            window.location.reload();
        }
    }

    setInterval(updateTimer, 1000);

    // Оновлення активності при взаємодії з сторінкою
    function updateActivity() {
        fetch('update_activity.php')
            .then(response => response.text())
            .then(data => {
                console.log('Активність оновлено:', data);
                // Оновлюємо час на сторінці
                timeLeft = InactivityTime;
                timeLeftElement.textContent = timeLeft;
                timeLeftElement.style.color = '#d9534f';

                const now = new Date();
                lastActivityElement.textContent = now.toLocaleTimeString();
            })
            .catch(error => console.log('Помилка оновлення активності:', error));
    }

    document.addEventListener('click', updateActivity);
    document.addEventListener('keypress', updateActivity);
    document.addEventListener('scroll', updateActivity);
    document.addEventListener('mousemove', updateActivity);
</script>
</body>
</html>