<?php
/**
 * @author : Elefranc1
 */
require "./src/managers/ProductManager.php";
require "./src/managers/CategoryManager.php";
require "./src/managers/VariantManager.php";

class AdminPanelController
{
    // function index() : void that will display the homepage
    public function index(array $get, array $post = null)
    {
            if(isset($_SESSION) && $_SESSION['user']['is_admin']==1){
            require "./src/templates/adminPanel.phtml"; 
            }
            else{
            require "./src/templates/home_screen.phtml";
            }
    }
    
    // methods to manage USERS
    public function manageUser(array $get, array $post = null)
    {
            if(isset($_SESSION) && $_SESSION['user']['is_admin']==1)
            {
                // If the admin came from a form, it means that he wanted to delete a user
                if(!empty($_POST)){
                    $delUserId=$_POST['userId'];
                    $userManager= new UserManager();
                    $userManager->deleteUserById($delUserId);
                }
                
                $userManager = new UserManager();
                $userArray= $userManager->getAllNonAdminUsers();
                
                //require "./src/templates/layout-admin.phtml";
                require "./src/templates/adminUsers.phtml";
            }
            else{
            echo "Non Admin connecté !";
            require "./src/templates/home_screen.phtml";
            }
            
    }

    
    // methods to manage PRODUCTS
    public function manageProduct()
    {
        var_dump($_POST);
        $productManager = new ProductManager();
        // if a product has been deleted in the previous page
        if(isset($_POST['delProductId']))
        {
            $delProductId=$_POST['delProductId'];
            $productManager->deleteProductByid($delProductId);
        }
        
        //loading page
        if(isset($_SESSION['user']) && $_SESSION['user']['is_admin']==1)
            {
                //loading categories
                 $categoryManager = new CategoryManager();
                 $categories=$categoryManager->getAllCategories();
                 if(isset($_POST['categorySelected']))
                 {
                    $categoryIdFilter=intval($_POST['categorySelected']);
                 }
                 else
                 {
                    $categoryIdFilter=0;
                 }
                var_dump($categoryIdFilter);
                
                //If no category has been selected
                if($categoryIdFilter==0)
                {
                    
                    // Pagination
                    $productsNumber=$productManager->getNumberOfProducts();
                    $numberOfPages=0;
                    if($productsNumber>10)
                    {
                        if($productsNumber%10==0)
                        {
                            $numberOfPages=$productsNumber/10;
                        }
                        else
                        {
                            $numberOfPages=intval($productsNumber/10)+1;
                        }
                    }
                    $prodCat= $productManager->getVProductsWithCategories(1);
                }
                //else if a category has been selected
                else
                { 
                    
                    // Pagination
                    $productsNumber=$productManager->getNumberOfProductsByCategoryId($categoryIdFilter);
                    var_dump($productsNumber);
                    $numberOfPages=0;
                    if($productsNumber>10)
                    {
                        if($productsNumber%10==0)
                        {
                            $numberOfPages=$productsNumber/10;
                        }
                        else
                        {
                            $numberOfPages=intval($productsNumber/10)+1;
                        }
                    }
                    $prodCat= $productManager->getVProductsWithCategoriesByCategoryId($categoryIdFilter, 1);                    
                }
                
                require "./src/templates/adminProducts.phtml";
            }
            else
            {
            require "./src/templates/home_screen.phtml";
            }
    }
    
    // function manageCategories() : void that will display the category management page
    public function manageCategories(array $get, array $post = null)
    {
        $categoryManager = new CategoryManager();
        // if a category has been deleted in the previous page
        if(isset($_POST['delCategoryId']))
        {
            $delCategoryId=$_POST['delCategoryId'];
            $categoryManager->deleteCategoryById($delCategoryId);
        }
        
        // if a category has been created in the previous page
        if(isset($_POST['newCategory']) && !empty($_POST['newCategory']))
        {

            $newCategoryLabel=$_POST['newCategory'];
            $categoryManager->createNewCategory($newCategoryLabel);

        }
        
        
        //loading page
        if(isset($_SESSION['user']) && $_SESSION['user']['is_admin']==1)
        {
            $categoryManager = new CategoryManager();
            $categoryArray= $categoryManager->getAllVCategoriesWithProductCount();
            require "./src/templates/adminCategories.phtml";  
        }
        else
        {
            require "./src/templates/home_screen.phtml";
        }
    }
    
    
    // function showOrders() : void that will display every orders passed on the website
    public function showOrders()
    {
        $orderManager = new OrderManager();

        // if the correct user tries to open this page
        if(isset($_SESSION['user']) && $_SESSION['user']['is_admin'] == 1)
        {
            $orders = $orderManager->getAllOrders();
            //loading the page
            require "./src/templates/adminOrders.phtml";
        }
        else
        {
            header('location:/ProjetFinal/projet_freaky-kawaii-molds/'); 
        }
        
    }

}
