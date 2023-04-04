<?php  

class Product 
{
  public $sku;
  public $ean;
  public $shortDesc;
  public $name;
  public $manufacturer;
  public $price;
  public $stock;  
  
  const TABLE = 'products';

  function __construct($product_array) {
   
      $this->sku = $product_array['sku']??null;
      $this->ean = $product_array['ean']??null; 
      $this->shortDesc = $product_array['shortDesc']??null;
      $this->name = $product_array['name']??null; 
      $this->manufacturer = $product_array['manufacturer']??null;
      $this->price = $product_array['price']??null;
      $this->stock = $product_array['stock']??null;
  }

  public function toSqlValues() {
    return "'" . implode("', '", get_object_vars($this)) . "'";

  }

  public function compareTo($other) {
    return $this->sku == $other->sku && $this->stock != $other->stock;
  }
}
?>