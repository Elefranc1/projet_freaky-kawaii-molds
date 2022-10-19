<?php
/**
 * @author : Elefranc1
 */
require "./src/models/Category.php";


class CategoryManager extends DBConnect
{
    
    public function getAllCategories() : ?array
    {
        $query = $this->db->prepare('SELECT * FROM categories ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public function getCategoryById(int $id) : ?array
    {
        $query = $this->db->prepare('SELECT * FROM categories WHERE id=:id ');
        $parameters = [
        'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    // To create a new category, only a label is needed
    public function createNewCategory(string $label) : void
    {
        $query = $this->db->prepare('INSERT INTO categories (label) VALUES (:label)');
        $parameters = [
        'label' => $label
        ];
        $query->execute($parameters);
        return;
    }
    
    // This function deletes a category with a known id
    public function deleteCategoryById(int $id) : void
    {
        $query = $this->db->prepare('DELETE FROM categories WHERE id=:id');
        $parameters = [
        'id' => $id
        ];
        $query->execute($parameters);
    }
    
    // This view contains every category and the number of products they have
    public function getAllVCategoriesWithProductCount() : ?array
    {
        $query = $this->db->prepare('SELECT * FROM Categories_with_product_count');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
}