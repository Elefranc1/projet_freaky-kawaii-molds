<?php
/**
 * @author : Elefranc1
 */
require "./src/models/Product.php";


class ProductManager extends DBConnect
{
    
    public function getAllProducts() : ?array
    {
        $query = $this->db->prepare('SELECT * FROM products ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
}