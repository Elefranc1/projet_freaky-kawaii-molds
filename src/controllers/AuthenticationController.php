<?php

class AuthenticationController
{
    
    // function testPage() : void that will display the test page
    function testPage() : void
    {
        require './src/templates/page1.phtml'; 
    }

    // function signIn() : void that will display the SignIn form
    function signIn() : void
    {
        require './src/templates/signIn.phtml'; 
    }
    
    // function testPage() : void that will displau the SignUp form
    function signUp() : void
    {
        require './src/templates/signUp.phtml'; 
    }

    
}