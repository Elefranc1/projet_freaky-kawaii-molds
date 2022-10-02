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
            echo "Admin connecté !";
            require "./src/templates/adminPanel.phtml"; 
            }
            else{
            echo "Non Admin connecté !";
            require "./src/templates/home_screen.phtml";
            }
    }
    
    // methods to manage USERS
    public function manageUser(array $get, array $post = null)
    {
            if(isset($_SESSION) && $_SESSION['user']['is_admin']==1)
            {
                echo "Admin connecté !";
                // If the admin came from a form, it means that he wanted to delete a user
                if(!empty($_POST)){
                    $delUserId=$_POST['userId'];
                    $userManager= new UserManager();
                    $userManager->deleteUserById($delUserId);
                }
                
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
                require "./src/templates/adminProducts.phtml";
            }
            else
            {
            require "./src/templates/home_screen.phtml";
            }
    }

}
