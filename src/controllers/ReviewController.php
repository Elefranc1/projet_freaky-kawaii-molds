<?php
/**
 * @author : Elefranc1
 */

require_once "./src/managers/ReviewManager.php";

class ReviewController
{
    // function create() : void that will display the Review creation page
    public function createReview($productId)
    {
            $productManager = new ProductManager();
            $product = $productManager->getProductById($productId);
            
            // If a review has been previously sent
            if(isset($_POST) && !empty($_POST))
            {
                //Managing errors
                $errors=[];
                if(isset($_POST['reviewScore']) && trim($_POST['reviewScore'])!="")
                {
                  $score=$_POST['reviewScore'];  
                }
                else
                {
                    array_push($errors,"Veuillez renseigner une note (entre 0 et 5)");
                }
                
                if(isset($_POST['reviewText']) && trim($_POST['reviewText'])!="")
                {
                  $text=$_POST['reviewText'];  
                }
                else
                {
                    array_push($errors,"Veuillez renseigner un commentaire");
                }
                if(isset($_SESSION['user']))
                {
                    $authorId=$_SESSION['user']['id'];  
                }
                else
                {
                    array_push($errors,"Erreur inconnue, veuillez vous reconnecter");
                }
                
                //If there are some errors, we redirect the user to the review form
                if(!empty($errors))
                {
                    require "./src/templates/createReview.phtml";  
                }
                // else, we insert the reviw in the DB and redirect the user to the product page 
                else
                {
                    var_dump($_SESSION);
                    $review = new Review($productId,$authorId,$score,$text);
                    $reviewManager = new reviewManager();
                    $reviewManager->createReview($review);
                    echo "Evaluation créée ! ";
                    header('location:'.$_POST['productPage']); 
                }
            }
            else
            {
            //We load the page
            require "./src/templates/createReview.phtml"; 
            }
            
            
    }
    

    // function edit() : void that will display and allow the modification of an existing Review
    public function editReview($reviewId)
    {
            $reviewManager = new ReviewManager();
            $review = $reviewManager->getReviewById($reviewId);
            $productManager = new ProductManager();
            $product = $productManager->getProductById($review->getProductId());
            
            // We check if the correct user is connected
            // if not, we go back to the homescreen
            if(isset($_SESSION['user']) && $_SESSION['user']['id']!=$review->getAuthorId())
            {
                header('location:/ProjetFinal/projet_freaky-kawaii-molds/'); 
            }
            // else we proceed normally
            else
            {
                // If a review has been previously sent
                if(isset($_POST) && !empty($_POST))
                {
                    //Managing errors
                    $errors=[];
                    $reviewId=$review->getId();
                    $productId=$product->getId();
                    if(isset($_POST['reviewScore']) && trim($_POST['reviewScore'])!="")
                    {
                      $score=$_POST['reviewScore'];  
                    }
                    else
                    {
                        array_push($errors,"Veuillez renseigner une note (entre 0 et 5) pour enregistrer votre modification");
                    }
                    
                    if(isset($_POST['reviewText']) && trim($_POST['reviewText'])!="")
                    {
                      $text=$_POST['reviewText'];  
                    }
                    else
                    {
                        array_push($errors,"Veuillez renseigner un commentaire pour enregistrer votre modification");
                    }
                    if(isset($_SESSION['user']))
                    {
                        $authorId=$_SESSION['user']['id'];  
                    }
                    else
                    {
                        array_push($errors,"Utilisateur non reconnu, veuillez vous reconnecter");
                    }
                    
                    //If there are some errors, we redirect the user to the review form
                    if(!empty($errors))
                    {
                        require "./src/templates/editReview.phtml";  
                    }
                    // else, we insert the reviw in the DB and redirect the user to the product page 
                    else
                    {
                        $updatedReview = new Review($productId,$authorId,$score,$text);
                        $updatedReview->setId($reviewId);
                        $reviewManager->updateReview($updatedReview);
                        echo "Evaluation modifiée ! ";
                        header('location:'.$_POST['productPage']); 
                    }
                }
                else
                {
                //We load the page
                require "./src/templates/editReview.phtml"; 
                }
            }
            
    }

    // function delete() : void that will delete the review and redirect to the product page
    public function deleteReview($reviewId)
    {
        $reviewManager = new ReviewManager();
        $review = $reviewManager->getReviewById($reviewId);
        $productManager = new ProductManager();
        $product = $productManager->getProductById($review->getProductId());
        
        // We check if the correct user is connected
        // if not, we go back to the homescreen without deleting the review !
        if(isset($_SESSION['user']) && $_SESSION['user']['id']!=$review->getAuthorId())
        {
            header('location:/ProjetFinal/projet_freaky-kawaii-molds/'); 
        }
        // else we proceed normally and redirect to the product page after the review deletion
        else
        {
            $reviewManager->deleteReviewById($review->getId());
            header('location:/ProjetFinal/projet_freaky-kawaii-molds/product/'.$product->getId()); 
        }
            
    }
    
    
}
