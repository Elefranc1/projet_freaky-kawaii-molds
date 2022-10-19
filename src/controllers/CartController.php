<?php
/**
 * @author : Elefranc1
 */

class CartController
{
    // function index() : void that will display the shopping Cart
    public function index(int $userId)
    {
        // if an order has been sent
        if(isset($_SESSION['user']) 
        && $_SESSION['user']['id']==$userId 
        && isset($_POST['totalPrice']))
        {
            var_dump($_POST);
            //unset($_SESSION['cart']);
            
        }
        
        
        // if an article has been deleted
        if(isset($_SESSION['user']) 
        && $_SESSION['user']['id']==$userId 
        && isset($_POST['deleteArticle']))
        {
            unset($_SESSION['cart'][$_POST['deleteArticle']]);
        }
        
        // if an article has been added
        if(isset($_SESSION['user'])
        && $_SESSION['user']['id']==$userId 
        && isset($_POST['variantSelected']) 
        && isset($_POST['quantitySelected']) )
        {
            $variantManager = new VariantManager();
            //We retrieve variant selected
            $variant=$variantManager->getVariantById($_POST['variantSelected']);
            
            //we stock in $_SESSION the relevant informations
            $_SESSION["cart"][]=            
                [
                    "productId" => $_POST['productId'],
                    "productLabel" => $_POST['productLabel'],
                    "productMediaUrl" => $_POST['productMediaUrl'],
                    "variantId" => $variant['id'],
                    "variantLabel" => $variant['label'],
                    "variantPrice" => $variant['price'],
                    "quantitySelected" => $_POST['quantitySelected']
                ];
             
     
        }
        //loading the page
        require "./src/templates/shoppingCart.phtml";

    }
    
}
