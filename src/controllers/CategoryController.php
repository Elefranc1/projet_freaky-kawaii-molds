<?php
/**
 * @author : Elefranc1
 */

class CategoryController
{
    // function manageCategories() : void that will display the category management page
    public function manageCategories(array $get, array $post = null)
    {
            $categoryManager = new CategoryManager();
            $categoryArray= $categoryManager->getAllVCategoriesWithProductCount();
            require "./src/templates/adminCategories.phtml";  
    }
    
}
