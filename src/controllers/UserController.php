<?php
/**
 * @author : Elefranc1
 */
 
 require "./src/managers/MediaManager.php";
 
class UserController
{
    public function editUser(array $get, array $post = null) : void
    {
        $userId=$_SESSION['user']['id'];
        $userManager= new UserManager();
        $user=$userManager->getUserById($userId);
        $mediaManager= new MediaManager();
        $avatarUrl=$mediaManager->getUrlByMediaId($user->getMediaId());
        
        //If some properties are uninitialized, we give them a default value
        if(!isset($user->about))
        {
            $user->setAbout("");
        }
        require "./src/templates/userProfile.phtml";
    }

    public function updateUser(array $get, array $post = null) : void
    {
        if (empty($_SESSION))
        {
            require "./src/templates/home_screen.phtml"; 
        }
        else
        {
            $userId=$_SESSION['user']['id'];
            $userManager= new UserManager();
            $updatedUser=$userManager->getUserById($userId);
            $mediaManager= new MediaManager();
            
            
            //Managing errors
            $errors=[];
            if(isset($_POST) && !empty($_POST))
            {
                //Username
                if(isset($_POST['username']) && trim($_POST['username'])!="")
                {
                    $updatedUser->setUsername($_POST['username']);
                }
                else if (isset($_POST['username']) && trim($_POST['username'])=="")
                {
                     array_push($errors,"Veuillez renseigner un pseudonyme");
                }
                
                //Email
                if(isset($_POST['email']) && $_POST['email']!="")
                {
                    $updatedUser->setEmail($_POST['email']);
                }
                else if (isset($_POST['email']) && trim($_POST['email'])=="")
                {
                     array_push($errors,"Veuillez renseigner une adresse mail");
                }
                
                
                //Password
                if(isset($_POST['NewPassword']) && $_POST['NewPassword']!="")
                {
                    // Checking previous password
                    if($_POST['oldPassword']==$updatedUser->getPassword())
                    {
                        //Checking the 2 new passwords
                        if($_POST['NewPassword']==$_POST['newPassword-repeat'] )
                        {
                            $updatedUser->setPassword($_POST['NewPassword']);
                        }
                        else 
                        {
                            array_push($errors,"Les 2 mots de passe ne sont pas identiques");
                        }
                    }
                    else
                    {
                        array_push($errors,"Votre ancien mot de passe est erroné");                    
                    }
                }
    
                // about
                if(isset($_POST['about']) && $_POST['about']!="")
                {
                    $updatedUser->setAbout(trim($_POST['about']));
                }
                // avatar
                if(isset($_POST['avatar']) && $_POST['avatar']!="")
                {
                    $updatedUser->setMediaId($_POST['avatar']);
                }
                
              // Avatar uploaded 
                if(isset($_FILES["fileToUpload"]))
                {
                    
                    
                    // We upload the file on the server
                    $uploader = new FileUploader();
                    $uploader->setUploadRepo("/uploads/avatar/");
                    $media = $uploader->upload($_FILES["fileToUpload"]);
                    
                    // echo "<pre>";
                    // print_r($media);
                    // echo "</pre>";
                    
                    // We create an entry in the media table and update the $user
                    if($media!=null)
                    {
                    $mediaId=$mediaManager->createNewMedia($media);
                    $updatedUser->setMediaId($mediaId);
                    }
                    
                    var_dump($_POST);
                }
                
            // Update the user in DB
            $userManager->updateUser($updatedUser);
            
            }
            $user=$userManager->getUserById($userId);
            
            $avatarUrl=$mediaManager->getUrlByMediaId($user->getMediaId());
            require "./src/templates/userProfile.phtml";
        }
    }
}