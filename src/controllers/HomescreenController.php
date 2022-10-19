<?php
/**
 * @author : Elefranc1
 */

class HomescreenController
{
    // function index() : void that will display the homepage
    public function index(array $get, array $post = null)
    {
            $categoryManager = new CategoryManager();
            $productManager = new ProductManager();
            $categories = $categoryManager->getAllCategories();
            $availableProducts= $productManager->getAllVProductsAvailable();
            require "./src/templates/home_screen.phtml";  
    }
    
    
    // function categorySelected() : void that will display the homepage with products filtered by category
    public function categorySelected(int $categoryId)
    {
            $categoryManager = new CategoryManager();
            $productManager = new ProductManager();
            $categories = $categoryManager->getAllCategories();
            $availableProducts= $productManager->getAllVProductsAvailableByCategoryId($categoryId);
            require "./src/templates/home_screen.phtml";  
    }
    
    
}
