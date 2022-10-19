<?php
/**
 * @author : Elefranc1
 */
require "./src/models/User.php";


class UserManager extends DBConnect
{
    
    public function getAllUsers() : ?array
    {
        $query = $this->db->prepare('SELECT * FROM users ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
        public function getAllNonAdminUsers() : ?array // used in the manageUser screen
    {
        $query = $this->db->prepare('SELECT * FROM users WHERE is_admin=0');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
        
    public function getAllUserUsernames() : ?array
    {
        $query = $this->db->prepare('SELECT username FROM users ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
        public function getAllUserEmails() : ?array
    {
        $query = $this->db->prepare('SELECT email FROM users ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public function createNewUser(string $username, string $password, string $email) : void
    {
        $query = $this->db->prepare("INSERT INTO users( username, password, email, media_id, is_admin) 
        VALUES (:username,:password,:email,1,0)");
        $parameters = [
        'username' => $username,
        'password' => $password,
        'email' => $email
        ];
        $query->execute($parameters);
        $userArray = $query->fetchAll(PDO::FETCH_ASSOC);
        return;
    }

    public function getUserByEmail(string $email) : ?User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE email=:email");
        $parameters = [
        'email' => $email
        ];
        $query->execute($parameters);
        $userArray = $query->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($userArray))
        {
            $user = new User($userArray[0]['username'], $userArray[0]['password'], $userArray[0]['email']);
            $user->setId($userArray[0]['id']);
            $user->setIsAdmin($userArray[0]['is_admin']);
            $user->setMediaId($userArray[0]['media_id']);
            return $user;
        }
        else
        {
           return null; 
        }
    }
    
    public function getUserById(int $userId): ?User
    {
        $query = $this->db->prepare("SELECT * FROM users WHERE id=:id");
        $parameters = [
        'id' => $userId
        ];
        $query->execute($parameters);
        $userArray = $query->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($userArray))
        {
            $user = new User($userArray[0]['username'], $userArray[0]['password'], $userArray[0]['email']);
            $user->setId($userArray[0]['id']);
            $user->setIsAdmin($userArray[0]['is_admin']);
            if($userArray[0]['media_id']!=null)
            {
            $user->setMediaId($userArray[0]['media_id']);
            }
            if($userArray[0]['about']!=null)
            {
            $user->setAbout($userArray[0]['about']);
            }
            if($userArray[0]['birthdate']!=null)
            {
            //We need to format the date we are getting form the db
            $birthdate=date_create_from_format('Y-m-j h:i:s',  $userArray[0]['birthdate']);
            $user->setBirthdate($birthdate);
            }
            return $user;
        }
        else
        {
           return null; 
        }
    }
    
    public function updateUser(User $user): void
    {
        $query = $this->db->prepare("UPDATE users SET username=:username, email=:email, media_id=:media_id,
                                    about=:about WHERE id=:id");
                                    
        $userId=$user->getId();      
        $username=$user->getUsername();  
        $email=$user->getEmail();  
        $media_id=$user->getMediaId();  
        $about=$user->getAbout();  
        //$birthdate=$user->getBirthdate();  
                                    
        $parameters = [
        'id' => $userId,
        'username' => $username,
        'email' => $email,
        'media_id' => $media_id,
        'about' => $about
        //'birthdate' => $birthdate
        ];
        $query->execute($parameters);
        
        return;
    }
    
    public function deleteUserById(int $userId): void
    {
        // DELETE OR REAFFECT THE SONS FIRST
        // Transfer every orders to the special user "DELETED_USER"
        // ...
        // Transfer every "good" review to the special user "DELETED_USER" 
        // ...
        // Delete every "bad" review
        
        $query = $this->db->prepare("DELETE FROM users WHERE id=:id");
        $parameters = [
        'id' => $userId
        ];
        $query->execute($parameters);
        
        return;
    }
    

}