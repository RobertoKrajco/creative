<?php
require_once "Controller.php";
class ProductController extends Controller{

    function __construct() {
        parent::__construct();
    }

    public function index(){

        $query = "SELECT * FROM ".Product::TABLE;
        $result = $this->db->execute($query);
        $rows = [];
        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row;
            }
        } else {
            echo "No results found.";
        }
        
        return $rows;
    }

    public function insert(Product $product){

        $values = $product->toSqlValues();
        $query = "INSERT INTO ".Product::TABLE."(sku, ean, name, shortDesc, manufacturer, price, stock) VALUES (" . $values . ")";
        $result = $this->db->execute($query);
        return $result;

    } 

    public function delete(Product $product){}    

    public function update(Product $product){

        $query = "UPDATE ".Product::TABLE." SET stock = ? WHERE sku = ?";
        $stmt = $this->db->prepare($query);
        $stock = $product->stock;
        $sku = $product->sku;
        mysqli_stmt_bind_param($stmt,"is", $stock, $sku);
        $result = mysqli_stmt_execute($stmt);
    }

    public function exists($sku=null){

        $query = "SELECT COUNT(*) FROM ".Product::TABLE." WHERE sku = '".$sku."'";
        
        $result = $this->db->execute($query);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
                if($row[0]!=0){
                    return true;
                
            }
        } 
        return false;
    }

    //returns true if stock is different from expected
    public function differentStock($sku,$stock){

        $query = "SELECT stock FROM ".Product::TABLE." WHERE sku = '".$sku."'";
        
        $result = $this->db->execute($query);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_row($result);
                if($row[0]!=$stock){
                    return true;
                }
            
        } 
        return false;
    }
}