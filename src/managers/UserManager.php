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
    
        public function getAllNonAdminUsers() : ?array // used ine the manageUser screen
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
        $query = $this->db->prepare("INSERT INTO users( username, password, email, is_admin) 
        VALUES (:username,:password,:email,0)");
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
        if(!empty($userArray)){
            $user = new User($userArray[0]['username'], $userArray[0]['password'], $userArray[0]['email']);
            $user->setId($userArray[0]['id']);
            $user->setIsAdmin($userArray[0]['is_admin']);
            return $user;
        }
        else{
           return null; 
        }
    }
}