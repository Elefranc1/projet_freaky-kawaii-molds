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
            if($_SESSION['user']['is_admin']==1){
            echo "Admin connecté !";
            require "./src/templates/adminUsers.phtml";
            }
            else{
            echo "Non Admin connecté !";
            require "./src/templates/home_screen.phtml";
            }
            
    }

    
}
