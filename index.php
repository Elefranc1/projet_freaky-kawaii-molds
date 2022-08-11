<?php
    require "./src/controllers/RoutingController.php";
    
    $routing = new RoutingController();
    
    //Si une route a été définie dans l'url
    if(isset($_GET["route"]))
    {
        //on charge la page correspondante en envoyant toutes les infos en POST et GET
        $routing->matchRoute($_GET["route"], $_GET, $_POST);
    }
    else
    {
        //Sinon, on charge la page d'accueil par défaut
        $routing->matchRoute("homescreen", $_GET);   
    }
    
?>