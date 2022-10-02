<?php
/**
 * @author : Elefranc1
 */
require "./src/models/Variant.php";


class VariantManager extends DBConnect
{
    
    public function getAllVariantsByProductId(int $productId) : ?array
    {
        $query = $this->db->prepare('SELECT * FROM variants WHERE product_id=:productId ');
        $parameters= [
        'productId'=>$productId
        ];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    
    public function createNewVariant(int $productId, string $label, float $price) : void
    {
        $query = $this->db->prepare('INSERT INTO variants(product_id, label, price) 
        VALUES (:product_id,:label,:price);');
        $parameters= [
        'product_id'=>$productId,
        'label'=>$label,
        'price'=>$price
        ];
        $query->execute($parameters);
        return;
    }
    
    
    public function deleteVariantbyId(int $id) : void
    {
        $query = $this->db->prepare('DELETE FROM variants WHERE id=:id;');
        $parameters= [
        'id'=>$id
        ];
        $query->execute($parameters);
        return;
    }
    
}