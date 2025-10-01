<?php
require_once 'product.php';

class Category {
    public $name;
    private $products;

    public function __construct($name) {
        $this->name = $name;
        $this->products = array();
    }

    public function addProduct($product) {
        if ($product instanceof Product) {
            $this->products[] = $product;
        } else {
            throw new Exception("Можна додавати тільки об'єкти класу Product або його нащадків");
        }
    }

    public function displayProducts() {
        $output = "<div class='category'><h2>Категорія: {$this->name}</h2>";

        if (empty($this->products)) {
            $output .= "<p>У цій категорії ще немає товарів</p>";
        } else {
            foreach ($this->products as $product) {
                $output .= $product->getInfo();
            }
        }

        $output .= "</div>";
        return $output;
    }
}
?>