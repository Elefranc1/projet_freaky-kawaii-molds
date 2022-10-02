<?php
/**
 * @author : Elefranc1
 */
require "./src/models/Product.php";


class ProductManager extends DBConnect
{
    // This functions returns every products in an array
    public function getAllProducts() : ?array
    {
        $query = $this->db->prepare('SELECT * FROM products ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    // This function returns a product found thanks to its id
    public function getProductById(int $id) : ?product
    {
        $query = $this->db->prepare('SELECT * FROM products WHERE id=:id');
        $parameters = [
        'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $product= new Product($result['label'],$result['description'],$result['category_id']);
        $product->setId($result['id']);
        return $product;
    }
    
    // This function creates a product and returns the id of the newly created product
    public function createProduct(product $product) : ?int
    {
        // variables initialization
        $label=$product->getLabel();
        $description=$product->getDescription();
        $categoryId=$product->getCategoryId();
        
        $query = $this->db->prepare('INSERT INTO products (label, description, category_id)
        VALUES (:label, :description, :categoryId);');
        $parameters = [
        'label' => $label,
        'description' => $description,
        'categoryId' => $categoryId
        ];
        


        $query->execute($parameters);
        
        // we retrieve the new id so we can display the correct page
        $id = $this->db->lastInsertId();
        return $id;
    }
    
    // This function returns the last inserted product.id
    public function getLastProducId() : ?int
    {
        $id = $this->db->lastInsertId();
        return $id;
    }
    
    
     // This function updates a product
    public function updateProduct(product $product) : void
    {
        // variables initialization
        $id=$product->getId();
        $label=$product->getLabel();
        $description=$product->getDescription();
        $categoryId=$product->getCategoryId();
        $query = $this->db->prepare('UPDATE products SET
        label=:label, description=:description, category_id=:category_id 
        WHERE id=:id');
        $parameters = [
        'id' => $id,
        'label' => $label,
        'description' => $description,
        'category_id' => $categoryId
        ];
        $query->execute($parameters);
        
    }
    
    // This function deletes a product with a known id
    public function deleteProductByid(int $id) : void
    {
        $query = $this->db->prepare('DELETE FROM products WHERE id=:id');
        $parameters = [
        'id' => $id
        ];
        $query->execute($parameters);
    }
    
    // the view "product_with_category_name" contains the name of the 
    // associated products and categories in one place
    public function getAllVProductsWithCategories() : ?array
    {
        $query = $this->db->prepare('SELECT * FROM product_with_category_name ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // this function returns up to 10 products with its categories
    public function getVProductsWithCategories(int $page) : ?array
    {
        $offset=($page*10-10);
        $query = $this->db->prepare('SELECT * FROM product_with_category_name order by product_id DESC LIMIT 10 OFFSET :offset');
        $query->bindValue(':offset', (int) $offset, PDO::PARAM_INT); 
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    // this function returns the number of products in the database
    public function getNumberOfProducts() : ?int
    {
        $query = $this->db->prepare('SELECT COUNT(*) FROM products;');
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result['COUNT(*)'];
    }
    
    // This function searches product that matches a given string
    public function searchProduct(string $search) : ?array
    {
        $query = $this->db->prepare("SELECT * FROM product_with_category_name WHERE product_label like :find ORDER BY product_id DESC LIMIT 10");
        $query->bindValue('find',$search,PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    
}