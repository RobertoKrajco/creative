<?php
require_once "Product.php";
require_once "DatabaseConnection.php";
require_once "ProductController.php";

class App {

  private $productController;

  function __construct() {
    $this->productController = new ProductController();
  }

  function prepare($file_name){
    echo "Preparing...\n" ;
    if (($handle = fopen($file_name, "r")) !== FALSE) {
      $row = 0;
      $products_array = [];
      $product_attributes = [];
        while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
            $num = count($data);
            if($row == 0){
              for ($c=0; $c < $num; $c++) {
                $product_attributes[$c]=$data[$c];
              }
            }
            else
              for ($c=0; $c < $num; $c++) {
                $products_array[$row][$product_attributes[$c]] = $data[$c];
              }
            $row++;
          }
          
          fclose($handle);
          return $this->createArrayObject($products_array);
        }
      return [];
  }

  function createArrayObject($array){

    $products = array();
    foreach($array as $key => $product_array){
      $product = new Product($product_array);
      $products[$key]=$product;
    }
    return $products;

  }

  function import($products){
    echo "Importing...\n" ;
    foreach ($products as $product) {
        
        if(!$this->productController->exists($product->sku)){
          $result = $this->productController->insert($product);
          echo $product->sku." inserted successfully\n";
        }
    }

  }

  function updateStocks(array $newStock) {

    foreach($newStock as $new){
      if($this->productController->differentStock($new->sku,$new->stock)){
        $this->productController->update($new);
        echo $new->sku." updated successfully\n";
      }
    }
    
  }
}

?>