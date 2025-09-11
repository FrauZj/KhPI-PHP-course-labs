<?php

echo "<h2>1. Базовий PHP-скрипт</h2>";

echo "Hello, World!<br><br>";


echo "<h2>2. Змінні та типи даних</h2>";

// Оголошення змінних різних типів
$stringVar = "Це рядковий текст";      // Рядкова змінна
$intVar = 42;                          // Цілочисельна змінна
$floatVar = 3.14;                      // Число з плаваючою комою
$boolVar = true;                       // Булеве значення

// Виведення значень змінних
echo "Значення змінних:<br>";
echo "stringVar: " . $stringVar . "<br>";
echo "intVar: " . $intVar . "<br>";
echo "floatVar: " . $floatVar . "<br>";
echo "boolVar: " . ($boolVar ? 'true' : 'false') . "<br><br>";

// Виведення типів змінних
echo "Типи змінних:<br>";
echo "stringVar: ";
var_dump($stringVar);
echo "<br>intVar: ";
var_dump($intVar);
echo "<br>floatVar: ";
var_dump($floatVar);
echo "<br>boolVar: ";
var_dump($boolVar);
echo "<br><br>";

echo "<h2>3. Конкатенація рядків</h2>";

// Створення двох рядкових змінних
$firstName = "Іван";
$lastName = "Іванович";

// Об'єднання рядків та виведення результату
$fullName = $firstName . " " . $lastName;
echo "Повне ім'я: " . $fullName . "<br><br>";

echo "<h2>4. Умовні конструкції</h2>";

// Створення числової змінної
$number = 15;

// Перевірка на парність/непарність
if ($number % 2 == 0) {
    echo "Число " . $number . " є парним<br><br>";
} else {
    echo "Число " . $number . " є непарним<br><br>";
}

echo "<h2>5. Цикли</h2>";

// Цикл for для виведення чисел від 1 до 10
echo "Числа від 1 до 10 (for): ";
for ($i = 1; $i <= 10; $i++) {
    echo $i . " ";
}
echo "<br>";

// Цикл while для виведення чисел від 10 до 1
echo "Числа від 10 до 1 (while): ";
$j = 10;
while ($j >= 1) {
    echo $j . " ";
    $j--;
}
echo "<br><br>";

echo "<h2>6. Масиви</h2>";

// Створення асоціативного масиву з інформацією про студента
$student = [
    'first_name' => 'Михайло',
    'last_name' => 'П',
    'age' => 19,
    'specialty' => 'Комп\'ютерні науки'
];

echo "Інформація про студента:<br>";
foreach ($student as $key => $value) {
    echo ucfirst(str_replace('_', ' ', $key)) . ": " . $value . "<br>";
}

$student['average_grade'] = 4.8;

echo "<br>Оновлена інформація про студента:<br>";
foreach ($student as $key => $value) {
    echo ucfirst(str_replace('_', ' ', $key)) . ": " . $value . "<br>";
}
?>