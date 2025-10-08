<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Банківська система - Тестування</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }


        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        header {
            background:  rgba(0, 0, 0, 0.8);
            color: white;
            padding: 25px;
            text-align: center;
        }


        .result {
            background-color: white;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid #e9ecef;
            white-space: pre-line;
            line-height: 1.5;
        }


        .error {
            color: #dc3545;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container">
    <header>
        <h1>Банківська система</h1>
        <div class="subtitle">Тестування об'єктно-орієнтованої реалізації рахунків</div>
    </header>

    <div class="content">
        <?php
        interface AccountInterface
        {
            public function deposit($amount);
            public function withdraw($amount);
            public function getBalance();
        }

        class BankAccount implements AccountInterface
        {
            const MIN_BALANCE = 0;

            protected $balance;
            protected $currency;

            public function __construct($initialBalance = 0, $currency = "USD")
            {
                $this->balance = $initialBalance;
                $this->currency = $currency;
            }

            public function deposit($amount)
            {
                try {
                    if (!is_numeric($amount) || $amount <= 0) {
                        throw new Exception("Сума поповнення має бути позитивним числом");
                    }

                    $this->balance += $amount;
                    return $this->balance;
                } catch (Exception $e) {
                    throw new Exception("Помилка при поповненні: " . $e->getMessage());
                }
            }

            public function withdraw($amount)
            {
                try {
                    if (!is_numeric($amount) || $amount <= 0) {
                        throw new Exception("Сума зняття має бути позитивним числом");
                    }

                    if ($amount > $this->balance) {
                        throw new Exception("Недостатньо коштів на рахунку. Поточний баланс: " . $this->getBalance());
                    }

                    $newBalance = $this->balance - $amount;
                    if ($newBalance < self::MIN_BALANCE) {
                        throw new Exception("Баланс не може бути меншим за мінімальний: " . self::MIN_BALANCE);
                    }

                    $this->balance = $newBalance;
                    return $this->balance;
                } catch (Exception $e) {
                    throw new Exception("Помилка при знятті: " . $e->getMessage());
                }
            }

            public function getBalance(): string
            {
                return $this->balance . " " . $this->currency;
            }

        }

        class SavingsAccount extends BankAccount
        {
            private static $interestRate = 0.05; // 5% річних

            public static function setInterestRate($rate)
            {
                if (!is_numeric($rate) || $rate < 0) {
                    throw new Exception("Відсоткова ставка має бути невід'ємним числом");
                }
                self::$interestRate = $rate;
            }

            public static function getInterestRate(): string
            {
                return self::$interestRate * 100 . "%";
            }

            public function applyInterest()
            {
                try {
                    $interest = $this->balance * self::$interestRate;
                    $this->balance += $interest;
                    return $interest;
                } catch (Exception $e) {
                    throw new Exception("Помилка при нарахуванні відсотків: " . $e->getMessage());
                }
            }
        }

        echo "<div class='test-section'>";
        echo "<h2>1. Тестування базового рахунку</h2>";
        echo "<div class='result'>";
        try {
            $account1 = new BankAccount(100, "USD");
            echo "Створено рахунок з балансом: <span class='highlight'>" . $account1->getBalance() . "</span><br>";

            $account1->deposit(50);
            echo "Поповнено на 50. Баланс: <span class='highlight'>" . $account1->getBalance() . "</span><br>";

            $account1->withdraw(30);
            echo "Знято 30. Баланс: <span class='highlight'>" . $account1->getBalance() . "</span><br>";

        } catch (Exception $e) {
            echo "<span class='error'>Помилка: " . $e->getMessage() . "</span><br>";
        }
        echo "</div>";
        echo "</div>";

        echo "<div class='test-section'>";
        echo "<h2>2. Тестування накопичувального рахунку</h2>";
        echo "<div class='result'>";
        try {
            $savingsAccount = new SavingsAccount(1000, "USD");
            echo "Створено накопичувальний рахунок з балансом: <span class='highlight'>" . $savingsAccount->getBalance() . "</span><br>";
            echo "Поточна відсоткова ставка: <span class='highlight'>" . SavingsAccount::getInterestRate() . "</span><br>";

            $interest = $savingsAccount->applyInterest();
            echo "Нараховано відсотків: <span class='highlight'>" . $interest . " USD</span><br>";
            echo "Баланс після нарахування відсотків: <span class='highlight'>" . $savingsAccount->getBalance() . "</span><br>";

            // Зміна відсоткової ставки
            SavingsAccount::setInterestRate(0.07);
            echo "Нова відсоткова ставка: <span class='highlight'>" . SavingsAccount::getInterestRate() . "</span><br>";

            $interest = $savingsAccount->applyInterest();
            echo "Нараховано відсотків: <span class='highlight'>" . $interest . " USD</span><br>";
            echo "Баланс після нарахування відсотків: <span class='highlight'>" . $savingsAccount->getBalance() . "</span><br>";

        } catch (Exception $e) {
            echo "<span class='error'>Помилка: " . $e->getMessage() . "</span><br>";
        }

        echo "<div class='test-section'>";
        echo "<h2>3. Тестування обробки помилок</h2>";
        echo "<div class='result'>";

        // Тестування помилки недостатності коштів
        echo "<strong>Перевірка недостатності коштів:</strong><br>";
        try {
            $testAccount = new BankAccount(50, "USD");
            $testAccount->withdraw(100);
        } catch (Exception $e) {
            echo "<span class='error'>Помилка: " . $e->getMessage() . "</span><br>";
        }

        // Тестування помилки негативної суми
        echo "<br><strong>Перевірка негативної суми:</strong><br>";
        try {
            $testAccount = new BankAccount(100, "USD");
            $testAccount->deposit(-10);
        } catch (Exception $e) {
            echo "<span class='error'>Помилка: " . $e->getMessage() . "</span><br>";
        }

        // Тестування помилки некоректної суми зняття
        echo "<br><strong>Перевірка некоректної суми зняття:</strong><br>";
        try {
            $testAccount = new BankAccount(100, "USD");
            $testAccount->withdraw(0);
        } catch (Exception $e) {
            echo "<span class='error'>Помилка: " . $e->getMessage() . "</span><br>";
        }


        // Додаткове тестування з різними валютами
        echo "<div class='test-section'>";
        echo "<h2>4. Тестування з різними валютами</h2>";
        echo "<div class='result'>";
        try {
            $eurAccount = new BankAccount(200, "EUR");
            echo "Створено рахунок в EUR: <span class='highlight'>" . $eurAccount->getBalance() . "</span><br>";

            $uahAccount = new SavingsAccount(5000, "UAH");
            echo "Створено накопичувальний рахунок в UAH: <span class='highlight'>" . $uahAccount->getBalance() . "</span><br>";

            $uahAccount->applyInterest();
            echo "Баланс після нарахування відсотків: <span class='highlight'>" . $uahAccount->getBalance() . "</span><br>";

        } catch (Exception $e) {
            echo "<span class='error'>Помилка: " . $e->getMessage() . "</span><br>";
        }
        ?>
    </div>
</div>
</body>
</html>