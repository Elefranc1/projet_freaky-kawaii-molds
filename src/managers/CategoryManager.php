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
    
    // To create a new category, only a label is needed
    public function createNewCategory(string $label)
    {
        $query = $this->db->prepare('INSERT INTO categories (label) 
                                    VALUES (:label) ');
        $parameters = [
        'label' => $label
        ];
        $query->execute();
    }

    
}