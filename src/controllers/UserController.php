<?php
/**
 * @author : Elefranc1
 */
//require "./src/managers/UserManager.php";

class UserController
{
    public function editUser(array $get, array $post = null) : void
    {
        $userId=$_SESSION['user']['id'];
        $userManager= new UserManager();
        $user=$userManager->getUserById($userId);
        require "./src/templates/userProfile.phtml";
    }

    
}