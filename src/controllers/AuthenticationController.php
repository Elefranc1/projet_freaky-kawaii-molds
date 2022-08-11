<?php

class AuthenticationController
{

    // function homescreen() : void qui devra faire afficher le template homescreen.phtml
    function homescreen() : void
    {
        require './src/templates/home_screen.phtml'; 
    }
    
    // function testPage() : void qui devra faire afficher le template page1.phtml
    function testPage() : void
    {
        require './src/templates/page1.phtml'; 
    }

    
}