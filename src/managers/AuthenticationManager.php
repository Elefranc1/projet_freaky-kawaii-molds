<?php

require "./src/models/User.php";

class AuthenticationManager
{
    private PDO $db;
    
    function __construct()
    {
        $this->db = new PDO(
        'mysql:host=db.3wa.io;port=3306;dbname=ericlefranc_freakyKawaiiMolds',
        'ericlefranc',
        '57adc17b299182075cca59edd2239253'
        );
    }
    
    public function getAllUsers() : array
    {
        $query = $this->db->prepare('SELECT * FROM users ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
        
    public function getAllUserUsernames() : array
    {
        $query = $this->db->prepare('SELECT username FROM users ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
}