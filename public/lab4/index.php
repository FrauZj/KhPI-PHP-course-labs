<!DOCTYPE html>
<html lang="uk">
<style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        margin: 20px;
        color: #333;
    }
    .product {
        border: 1px solid #ddd;
        padding: 15px;
        margin: 10px 0;
        border-radius: 5px;
    }
    .discounted {
        background-color: #f9f9f9;
        border-left: 4px solid #4CAF50;
    }
    .category {
        margin: 20px 0;
        padding: 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    h1, h2 {
        color: #2c3e50;
    }
    .error {
        color: red;
        font-weight: bold;
    }
</style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система управління товарами</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Система управління товарами</h1>

    <div id="output">
        <?php
        require_once 'product.php';
        require_once 'discountedProduct.php';
        require_once 'category.php';

        try {
            $product1 = new Product("Смартфон", 15000, "Сучасний смартфон з потрійною камерою");
            $product2 = new Product("Ноутбук", 25000, "Потужний ноутбук для роботи та ігор");

            $discountedProduct1 = new DiscountedProduct("Навушники", 2000, "Бездротові навушники", 15);
            $discountedProduct2 = new DiscountedProduct("Планшет", 12000, "Планшет для роботи та розваг", 20);

            echo "<h2>Окремі товари:</h2>";
            echo $product1->getInfo();
            echo $product2->getInfo();
            echo $discountedProduct1->getInfo();
            echo $discountedProduct2->getInfo();

            $electronicsCategory = new Category("Електроніка");
            $electronicsCategory->addProduct($product1);
            $electronicsCategory->addProduct($product2);
            $electronicsCategory->addProduct($discountedProduct1);

            $computersCategory = new Category("Комп'ютерна техніка");
            $computersCategory->addProduct($product2);
            $computersCategory->addProduct($discountedProduct2);

            echo "<h2>Категорії товарів:</h2>";
            echo $electronicsCategory->displayProducts();
            echo $computersCategory->displayProducts();

            try {
                $invalidProduct = new Product("Невірний товар", -100, "Товар з від'ємною ціною");
            } catch (Exception $error) {
                echo "<p class='error'>Помилка валідації: " . $error->getMessage() . "</p>";
            }

        } catch (Exception $error) {
            echo "<p class='error'>Сталася помилка: " . $error->getMessage() . "</p>";
        }
        ?>
    </div>
</body>
</html>