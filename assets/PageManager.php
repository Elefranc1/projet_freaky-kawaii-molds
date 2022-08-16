<?php

require "./src/models/Page.php";

class PageManager
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
    
    public function getAllPagesRoutes() : array
    {
        $query = $this->db->prepare('SELECT route FROM pages ');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    public function getPageByRoute(string $route) : Page
    {
        $query = $this->db->prepare('SELECT * FROM pages WHERE pages.route = :route');
        $parameters = [
            'route' => $route
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return new Page($result['id'], $result['route'], $result['title']);
    }
}