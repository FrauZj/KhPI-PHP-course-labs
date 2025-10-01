<?php
class Product {
    public $name;
    public $description;
    protected $price;

    public function __construct($name, $price, $description) {
        $this->name = $name;
        $this->setPrice($price);
        $this->description = $description;
    }

    public function setPrice($value) {
        if ($value < 0) {
            throw new Exception("Ціна не може бути від'ємною");
        }
        $this->price = $value;
    }

    public function getPrice() {
        return $this->price;
    }

    public function getInfo() {
        return "
            <div class='product'>
                <strong>Назва:</strong> {$this->name}<br>
                <strong>Ціна:</strong> {$this->getPrice()} грн<br>
                <strong>Опис:</strong> {$this->description}
            </div>
        ";
    }
}
?>