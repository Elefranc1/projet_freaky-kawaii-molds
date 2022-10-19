<?php
/**
 * @author : Elefranc1
 */

require_once "./src/managers/OrderManager.php";
require_once "./src/managers/ProductPictureManager.php";


class ProductController
{
    // function show() : void that will display the product
    // and all its relevant informations
    public function showProduct(int $productId)
    {
        $productManager = new ProductManager();
        $variantManager = new VariantManager();
        $categoryManager = new CategoryManager();
        $productPictureManager = new ProductPictureManager();
        $reviewManager = new ReviewManager();
    
        
        
        // loading page
        $product= $productManager->getProductById($productId);
        $variantsArray= $variantManager->getAllVariantsByProductId($productId);
        $category = $categoryManager->getCategoryById($product->getCategoryId());
        $mainMedia=$productPictureManager->getMainMedia($productId);
        $mainMediaUrl=$mainMedia['url'];
        $reviews=$reviewManager->getAllReviewsByProductId($productId);
        
        //We then check if the user has already reviewed the product
        $writtenReview=[];
        if(isset($_SESSION['user']))
        {
            $writtenReview=$reviewManager->getReviewByAuthorIdAndProductId($_SESSION['user']['id'],$productId);
        }
        if(empty($writtenReview))
        {
            $canReview=true;
        }
        else
        {
            $canReview=false;
        }
        
        require "./src/templates/showProduct.phtml"; 
    }
    
    
    // function edit() : void that will update and display the 
    // screen where the admin can change an existing product
    public function editProduct(int $productId)
    {
        $productManager = new ProductManager();
        $categoryManager= new CategoryManager();
        $variantManager= new VariantManager();
        $productPictureManager = new ProductPictureManager();
        $mediaManager= new MediaManager();
        
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
            if(isset($_POST['updateLabel']) && trim($_POST['updateLabel'])!="")
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
            
            //Updating the main image of the product
            if(isset($_FILES['mainFileToUpload']) && $_FILES['mainFileToUpload']['size']!=0)
            {
                // We upload the file on the server
                $uploader = new FileUploader();
                $uploader->setUploadRepo("/uploads/products/");
                $media = $uploader->upload($_FILES["mainFileToUpload"]);
                
                // echo "<pre>";
                // print_r($media);
                // echo "</pre>";
                
                // We create an entry in the media table and update the corresponding product_picture
                if($media!=null)
                {
                    $mediaId=$mediaManager->createNewMedia($media);
                    $productPicture = new ProductPicture($updatedProduct->getId(),$mediaId,1);
                    var_dump($productPicture);
                    $productPictureManager = new ProductPictureManager();
                    $productPictureId=$productPictureManager->updateProductPictureMain($productPicture);
                }
            }
            
            
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
            $mainMedia=$productPictureManager->getMainMedia($productId);
            $mainMediaUrl=$mainMedia['url'];
            require "./src/templates/editProduct.phtml"; 
        }
        else
        {
            header('location:/ProjetFinal/projet_freaky-kawaii-molds/'); 
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
            var_dump($_POST);
            var_dump($_FILES);
            //Managing errors
            $errors=[];
            
            //Main Picture
            if(isset($_FILES["fileToUpload"]) && $_FILES["fileToUpload"]["size"]==0)
            {
                 array_push($errors,"Veuillez charger l'image principale du produit");
            }
            
            //Label
            if(isset($_POST['newLabel']) && trim($_POST['newLabel'])!="")
            {
                $newLabel = $_POST['newLabel'];
            }
            else
            {
                array_push($errors,"Veuillez renseigner un nom pour le produit");
            }
            
            //Description
            if(isset($_POST['newDescription']) && trim($_POST['newDescription'])!="")
            {
                $newDescription = $_POST['newDescription'];
            }
            else
            {
                array_push($errors,"Veuillez renseigner une description");
            }
            
            //Catégorie
            if(isset($_POST['newCategoryId']) && trim($_POST['newCategoryId'])!="")
            {
                $newCatProdId = $_POST['newCategoryId'];
            }
            else
            {
                array_push($errors,"Veuillez choisir une catégorie");
            }

            
            if(count($errors) != 0 )
            {
            $categoriesArray= $categoryManager->getAllCategories();
            require "./src/templates/createProduct.phtml";
            }
            else
            {
                $newProduct = new Product($newLabel,$newDescription,$newCatProdId);
                $productManager = new ProductManager();
                $productId=$productManager->createProduct($newProduct);
                
                //Handling the main picture of the product
                if(isset($_FILES["fileToUpload"]))
                    {
                        // We upload the file on the server
                        $uploader = new FileUploader();
                        $uploader->setUploadRepo("/uploads/products/");
                        $media = $uploader->upload($_FILES["fileToUpload"]);
                        
                        // echo "<pre>";
                        // print_r($media);
                        // echo "</pre>";
                        
                        // We create an entry in the media table and update the table product_image
                        if($media!=null)
                        {
                        $mediaManager= new MediaManager();
                        $mediaId=$mediaManager->createNewMedia($media);
                        $productPicture = new ProductPicture($productId,$mediaId,1);
                        var_dump($productPicture);
                        $productPictureManager = new ProductPictureManager();
                        $productPictureId=$productPictureManager->createNewProductPictureMain($productPicture);
                        }
                        
                        var_dump($_POST);
                    }
            

            
                //Then we load the edit page of the new product for the user to complete it:
                $productManager = new ProductManager();
    
                $variantManager= new VariantManager();
                $product= $productManager->getProductById($productId);
                $categoriesArray= $categoryManager->getAllCategories();
                $variantsArray= $variantManager->getAllVariantsByProductId($productId);
                $string='/ProjetFinal/projet_freaky-kawaii-molds/admin/manageProduct/'.$productId;
                var_dump($string);
                header('location:'.$string); 
            }
        }
        
       
        // loading page
        else if(isset($_SESSION) && $_SESSION['user']['is_admin']==1)
        {
            $categoriesArray= $categoryManager->getAllCategories();
            require "./src/templates/createProduct.phtml"; 
        }
        else
        {
            header('location:/ProjetFinal/projet_freaky-kawaii-molds/'); 
        }
    }
    
    
    function searchProduct()
    {
        //Récupération du JS
        $content = file_get_contents("php://input");
        $data = json_decode($content,true);
        $categoryId=$data['categoryId'];
        $productManager = new ProductManager();
        if($categoryId!=0)
        {
            if($data['textToFind'])
            {
                $search="%".$data['textToFind']."%";
                //$search="%".$_POST['searchField']."%";
                $prodCat=$productManager->searchProductInCategory($categoryId,$search);
            }
            else
            {
               $prodCat=$productManager->getVProductsWithCategoriesByCategoryId($categoryId,1); 
            }
        }
        else
        {
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
        }
            
        require('./src/templates/formData/searchProduct.phtml');
    }
    
    function filterByCategory()
    {
        //Récupération du JS
        $content = file_get_contents("php://input");
        $data = json_decode($content,true);
        $productManager = new ProductManager();
        if($data['categoryId'])
        {
            $search="%".$data['categoryId']."%";
            //$search="%".$_POST['searchField']."%";
            $prodCat=$productManager->getAllVProductsWithCategoriesByCategoryId($search);
        }
        require('./src/templates/formData/productsfilteredByCategory.phtml');
    }
    
    
    function changePageProductAdmin()
    {
        //Récupération du JS
        $content = file_get_contents("php://input");
        $data = json_decode($content,true);
        $page=$data['page'];
        $categoryId=$data['categoryId'];
        $productManager = new ProductManager();
        if($categoryId!=0)
        {
            $prodCat=$productManager->getVProductsWithCategoriesByCategoryId($categoryId, $page);
        }
        else
        {
            $prodCat=$productManager->getVProductsWithCategories($page);

        }
        require('./src/templates/formData/_manageProductChangePage.phtml');
    }
    
}
