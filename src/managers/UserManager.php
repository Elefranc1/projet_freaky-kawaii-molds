<?php

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
        echo "<br>Je suis bien dans createNewUser !";
        $query = $this->db->prepare("INSERT INTO users( username, password, email, is_admin) 
        VALUES (:username,:password,:email,0)");
        $parameters = [
        'username' => $username,
        'password' => $password,
        'email' => $email
        ];
        $query->execute($parameters);
        $playerArray = $query->fetchAll(PDO::FETCH_ASSOC);
        return;
    }
}