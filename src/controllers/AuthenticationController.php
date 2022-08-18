<?php
/**
 * @author : Elefranc1
 */
require "./src/managers/UserManager.php";

class AuthenticationController
{
    //TO DO : testPage() A SUPPRIMER
    // function testPage() : void that will display the test page
    function testPage(array $get, array $post=null) : void
    {
        require './src/templates/page1.phtml'; 
    }

    // function signIn() : void that will display the SignIn form
    function signIn(array $get, array $post=null) : void
    {
        // If signIn form has been previously sent...
        if(!empty($post)){
            // Variable initialization 
            $errorConnexion=false;
            $email=strip_tags($post['email']);
            $password=$post['password'];
            $userManager = new UserManager();
            $DBuser=$userManager->getUserByEmail($email);

            // if a matching email has been found in the Database ...
            if(!empty($DBuser)){
                $DBUserPassword=$DBuser->getPassword();
                // ... we check if the password matches.
                // If the password matches, we go back to the homescreen and store the user infos in sesion
                if(password_verify($password, $DBUserPassword)){
                    $_GET['path']=null; // We set 'path'=NULL to display the nav and header again

                        //we stock in $_SESSION relevant informations 
                        $_SESSION["user"] = [
                            "id" => $DBuser->getId(),
                            "username" => $DBuser->getUsername(),
                            "is_admin" => $DBuser->getIsAdmin()
                        ];
                    require "./src/templates/home_screen.phtml"; 
                }
                else{
                // else we stay in the signIn form with an error message
                $errorConnexion=true;
                echo "<p class='error'>Email ou mot de passe invalide</p>";
                require './src/templates/signIn.phtml'; 
                }
            
            }
            
            else{
                // else we stay in the signIn form with an error message
                $errorConnexion=true;
                echo "<p class='error'>Email ou mot de passe invalide</p>";
                require './src/templates/signIn.phtml'; 
            }
            
        }
        else{
        require './src/templates/signIn.phtml';
        }
    }
    
    // function signUp() : void function that is called when a user tries to sign up
    function signUp(array $get, array $post=null) : void
    {
        // if a signUp form has been previously sent...
        if(!empty($post)){
            // Variable initialization
            $username=$post['username'];
            $email=strip_tags($post['email']);
            $password=$post['password'];
            $passwordRepeat=$post['password-repeat'];
            $duplicateUsername=false;
            $invalidUsername=false;
            $duplicateEmail=false;
            $passwordError=false;
            $userManager = new UserManager();
        
            // USERNAME VERIFICATION
            // SPECIAL CHAR FORDBIDDEN
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $username)){
                // one or more of the 'special characters' found in $usernames
                $invalidUsername=true;
            }
            // DUPLICATE
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
                // We encrypt the password before inserting it into the DB
                $password = password_hash($password,PASSWORD_BCRYPT);
            }
            
            // If the username and the email are not already in the DB, 
            // and if  the password verification and is OK
            // and if the username doesn't contain any special char ...
            if(!$duplicateUsername && !$duplicateEmail && !$passwordError && !$invalidUsername){
                //TEST
                echo "L'utilisateur " . $username . " a été ajouté en base !";
                $userManager->createNewUser($username,$password,$email);
                $_GET['path']=null; // We set 'path'=NULL to display the nav and header again
                require "./src/templates/home_screen.phtml";  
                
            }
            else{
                // DISPLAY ERROR MESSAGE(S)
                require './src/templates/signUp.phtml'; 
                if($duplicateUsername){
                    echo "<p class='error'>Le nom d'utilisateur \"".$username."\"  est déjà pris</p>";
                }
                if($invalidUsername){
                    echo "<p class='error'>Le nom d'utilisateur \"".$username."\"  possède un ou plusieurs caractères spéciaux</p>";
                }
                if($duplicateEmail){
                    echo "<p class='error'>L'adresse \"".$email."\" est déjà utilisée</p>";
                }
                if($passwordError){
                    echo "<p class='error'>Les mots de passe saisis ne sont pas identiques</p>";
                }
            }
            
            
            
            
        }
        
        
        
        
        
        
        // else we just diplay the sign up form
        else {
        require './src/templates/signUp.phtml'; 
        }
    }
    
    

    
}