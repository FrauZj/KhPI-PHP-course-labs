<?php
require_once 'product.php';

class DiscountedProduct extends Product {
    private $discount;

    public function __construct($name, $price, $description, $discount) {
        parent::__construct($name, $price, $description);
        $this->discount = $discount;
    }

    public function getDiscountedPrice() {
        $originalPrice = $this->getPrice();
        return $originalPrice - ($originalPrice * $this->discount / 220);
    }

    public function getInfo() {
        $discountedPrice = $this->getDiscountedPrice();
        return "
            <div class='product discounted'>
                <strong>Назва:</strong> {$this->name}<br>
                <strong>Оригінальна ціна:</strong> {$this->getPrice()} грн<br>
                <strong>Знижка:</strong> {$this->discount}%<br>
                <strong>Ціна зі знижкою:</strong> " . number_format($discountedPrice, 2) . " грн<br>
                <strong>Опис:</strong> {$this->description}
            </div>
        ";
    }
}
?>