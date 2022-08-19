<?php
/**
 * @author : Elefranc1
 */

class AdminPanelController
{
    // function index() : void that will display the homepage
    public function index(array $get, array $post = null)
    {
            if($_SESSION['user']['is_admin']==1){
            echo "Admin connecté !";
            require "./src/templates/adminPanel.phtml"; 
            }
            else{
            echo "Non Admin connecté !";
            require "./src/templates/home_screen.phtml";
            }
            
    }
    
    
    public function manageUser(array $get, array $post = null)
    {
            if($_SESSION['user']['is_admin']==1)
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

    
}
