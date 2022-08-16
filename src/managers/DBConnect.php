<?php

class DBConnect
    {
        protected PDO $db;
      
            function __construct()
            {
                try{
                    $this->db = new PDO(
                    'mysql:host=db.3wa.io;port=3306;dbname=ericlefranc_freakyKawaiiMolds',
                    'ericlefranc',
                    '57adc17b299182075cca59edd2239253'
                    );
                }catch (PDOException $e){
                        print"Problème de connexion à la base de données: " . $e ->getMessage() ."<br/>";
                        die();
                }
            }
    }
    
?>