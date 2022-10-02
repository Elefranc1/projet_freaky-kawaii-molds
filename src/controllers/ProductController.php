<?php
/**
 * @author : Elefranc1
 */

class ProductController
{
    // function edit() : void that will update and display the 
    // screen where the admin can change an existing product
    public function editProduct(int $productId)
    {
        $productManager = new ProductManager();
        $categoryManager= new CategoryManager();
        $variantManager= new VariantManager();
        
        // if we come to the page without a form being sent,
        // we unset the SESSION lists associated with the variants
        if(!isset($_POST) || empty($_POST))
        {
            //Resetting the variants stocked in $_SESSION 
            $_SESSION["addedVariants"]=array();
            $_SESSION["removedVariants"]=array();
        }
        
        
        // if the product has been previously updated
        if(isset($_POST) && !empty($_POST))
        {
            // Updating the product itself
            $updatedProduct=$productManager->getProductById($productId);
            if(isset($_POST['updateLabel']))
            {
                $updatedProduct->setLabel($_POST['updateLabel']) ;              
            }
            if(isset($_POST['updateDescription']))
            {
                $updatedProduct->setDescription($_POST['updateDescription']) ;               
            }
            if(isset($_POST['updateCategoryId']))
            {
                $updatedProduct->setCategoryId($_POST['updateCategoryId']) ;               
            }

            $productManager->updateProduct($updatedProduct);
            
            //Updating the variants associated
            
            //Creating all the new Variants in $_SESSION["addedVariants"]
            if(!empty($_SESSION["addedVariants"]))
            {
                foreach($_SESSION["addedVariants"] as $key=>$addedVariant)
                {
                    $variantLabel=$_SESSION["addedVariants"][$key]['label'];
                    $variantPrice=floatval($_SESSION["addedVariants"][$key]['price']);
                     $variantManager->createNewVariant($productId,$variantLabel,$variantPrice);
                }
            }
            
            //Deleting all the Variants in $_SESSION["removedVariants"]
            if(!empty($_SESSION["removedVariants"]))
            {
                foreach($_SESSION["removedVariants"] as $key=>$removedVariant)
                {
                    $variantId=$_SESSION["removedVariants"][$key]['id'];
                    $variantManager->deleteVariantbyId($variantId);
                }
            }
            
        //Resetting the variants stocked in $_SESSION 
        $_SESSION["addedVariants"]=array();
        $_SESSION["removedVariants"]=array();
        
        }
        
        // loading page
        if(isset($_SESSION) && $_SESSION['user']['is_admin']==1)
        {
            $product= $productManager->getProductById($productId);
            $categoriesArray= $categoryManager->getAllCategories();
            $variantsArray= $variantManager->getAllVariantsByProductId($productId);
            require "./src/templates/editProduct.phtml"; 
        }
        else
        {
            echo "Non Admin connecté !";
            require "./src/templates/home_screen.phtml";
        }
    }
    
    // adding a new variant in SESSION to create once the form is submitted
    public function addVariant()
    {
        if(!isset($_SESSION["addedVariants"]))
        {
            //we stock in $_SESSION relevant informations 
            $_SESSION["addedVariants"] = [
                "Id" => $_POST['variantId'],
                "label" => $_POST['variantLabel'],
                "price" => $_POST['variantPrice']
            ];
        }
        else
        {
            $_SESSION["addedVariants"][]=[
                "id" => $_POST['variantId'],
                "label" => $_POST['variantLabel'],
                "price" => $_POST['variantPrice']
            ];
        }
        echo json_encode($_SESSION);
    }

    // cancelling a new Variant before submission
    public function cancelVariant()
    {
        if(isset($_SESSION["addedVariants"]) && !empty($_SESSION["addedVariants"]))
        {
            foreach($_SESSION["addedVariants"] as $key=>$addedVariant )
            {
                if(intval($addedVariant['id']) == intval($_POST['variantId']))
                {
                echo json_encode($addedVariant);  
                //We remove the element if we find a match
                 unset($_SESSION["addedVariants"][$key]);
 
                }
            }
        }
        echo json_encode($_SESSION);        
    }
    
    // deleteing an already existing variant
    public function removeVariant()
    {
        if(!isset($_SESSION["removedVariants"]))
        {
            //we stock in $_SESSION relevant informations 
            $_SESSION["removedVariants"] = [
                "id" => $_POST['variantId'],
            ];
        }
        else
        {
            $_SESSION["removedVariants"][]=[
                "id" => $_POST['variantId'],
            ];
        }
        echo json_encode($_SESSION);
    }
    
    // function createProuct() :
    public function createProduct()
    {
        
        $categoryManager= new CategoryManager();
        //If a product has been created, we insert it in the database
        if(isset($_POST) && !empty($_POST))
        {
            $newLabel = $_POST['newLabel'];
            $newDescription = $_POST['newDescription'];
            $newCatProdId = $_POST['newCategoryId'];
            $newProduct = new Product($newLabel,$newDescription,$newCatProdId);
            $productManager = new ProductManager();
            $productId=$productManager->createProduct($newProduct);
            //Then we load the edit page of the new product :
            $productManager = new ProductManager();

            $variantManager= new VariantManager();
            $product= $productManager->getProductById($productId);
            $categoriesArray= $categoryManager->getAllCategories();
            $variantsArray= $variantManager->getAllVariantsByProductId($productId);
            var_dump($product);
            var_dump($categoriesArray);
            var_dump($variantsArray);
            $string='/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/'.$productId;
            var_dump($string);
            header('location:'.$string); 
        }
        
       
        // loading page
        else if(isset($_SESSION) && $_SESSION['user']['is_admin']==1)
        {
            $categoriesArray= $categoryManager->getAllCategories();
            require "./src/templates/createProduct.phtml"; 
        }
        else
        {
            echo "Non Admin connecté !";
            require "./src/templates/home_screen.phtml";
        }
    }
    
    
    function searchProduct()
    {
        //Récupération du JS
        $content = file_get_contents("php://input");
        $data = json_decode($content,true);
        $productManager = new ProductManager();
        if($data['textToFind'])
        {
            $search="%".$data['textToFind']."%";
            //$search="%".$_POST['searchField']."%";
            $prodCat=$productManager->searchProduct($search);
        }
        else
        {
           $prodCat=$productManager->getVProductsWithCategories(1); 
        }
        require('./src/templates/formData/searchProduct.phtml');
    }
    
    
    function changePageProductAdmin()
    {
        //Récupération du JS
        $content = file_get_contents("php://input");
        $data = json_decode($content,true);
        $page=$data['page'];
        $productManager = new ProductManager();
        $prodCat=$productManager->getVProductsWithCategories($page);
        require('./src/templates/formData/_manageProductChangePage.phtml');
    }
    
}
