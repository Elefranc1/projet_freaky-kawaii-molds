<?php
/**
 * @author : Gaellan
 */

class HomescreenController
{
    // function index() : void that will display the homepage
    public function index(array $get, array $post = null)
    {
            require "./src/templates/home_screen.phtml";  
    }
    

    
}
