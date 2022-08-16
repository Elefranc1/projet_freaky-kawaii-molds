<?php
require "./src/managers/UserManager.php";

class AuthenticationController
{
    
    // function testPage() : void that will display the test page
    function testPage(array $get, array $post=null) : void
    {
        require './src/templates/page1.phtml'; 
    }

    // function signIn() : void that will display the SignIn form
    function signIn(array $get, array $post=null) : void
    {
        require './src/templates/signIn.phtml'; 
    }
    
    // function signUp() : void function that is called when a user tries to sign up
    function signUp(array $get, array $post=null) : void
    {
        // if a signUp form has been previously sent...
        if(!empty($post)){
            // Variable initialization
            $username=strip_tags($post['username']);
            $email=strip_tags($post['email']);
            $password=$post['password'];
            $passwordRepeat=$post['password-repeat'];
            $duplicateUsername=false;
            $duplicateEmail=false;
            $passwordError=false;
            $userManager = new UserManager();
        
            // USERNAME VERIFICATION
            $usernameArray = $userManager->getAllUserUsernames();
           for ($i=0,$max=count($usernameArray);$i<$max;$i++){
                if($username===$usernameArray[$i]['username']){
                    $duplicateUsername=true;
                }
            }

            
            // EMAIL VERIFICATION
            $emailArray = $userManager->getAllUserEmails();
            for ($i=0,$max=count($emailArray);$i<$max;$i++){
                if($email===$emailArray[$i]['email']){
                    $duplicateEmail=true;
                }
            }
            
            // PASSWORD CONFIRMATION VERIFICATION
            if($password!==$passwordRepeat){
                $passwordError=true; 
            }
            else{
                // We encrypt the password before inserting into the DB
                $password = password_hash($password,PASSWORD_BCRYPT);
            }
            
            // If the username and the email are not already in the DB, 
            // and if  the password verification is OK...
            if(!$duplicateUsername && !$duplicateEmail && !$passwordError){
                //TEST
                echo "L'utilisateur " . $username . " a été ajouté en base !";
                $userManager->createNewUser($username,$password,$email);
                require "./src/templates/home_screen.phtml";  
                
            }
            else{
                require './src/templates/signUp.phtml'; 
                if($duplicateUsername){
                    echo "<p class='error'>Le nom d'utilisateur \"".$username."\"  est déjà pris</p>";
                }
                if($duplicateEmail){
                    echo "<p class='error'>L'adresse \"".$email."\" est déjà utilisée</p>";
                }
                if($passwordError){
                    echo "<p class='error'>Les mots de passe saisis ne sont pas identiques</p>";
                }
            }
            
            
            
            
        }
        
        
        
        
        
        
        // else
        else {
        require './src/templates/signUp.phtml'; 
        }
    }
    
    

    
}