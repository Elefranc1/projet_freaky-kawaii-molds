<?php
/**
 * @author : Elefranc1
 */
require "./src/controllers/AuthenticationController.php";
require "./src/managers/PageManager.php";

class RoutingController
{
    private PageManager $pageManager;
    
    function __construct()
    {
        $this->pageManager = new PageManager();
    }
    
    private function sortRoute(string $route, array $get, array $post = null) : void
    {
        if($route === "homescreen")
        {
            $authenticationController = new AuthenticationController();
             $authenticationController->homescreen();
        }
        else if($route === "test")
        {
            $authenticationController = new AuthenticationController();
            $authenticationController->testPage($post);
        }
        else
        {
            echo "<h1>404 page not found</h1>";
        }
    }
    
    public function matchRoute(string $route = "homescreen", array $get, array $post = null) : void
    {
        $existingRoutes = $this->pageManager->getAllPagesRoutes();
        
        $found = false;
        
        foreach($existingRoutes as $item)
        {
            if($route === $item["route"])
            {
                $found = true;
                $this->sortRoute($route, $get, $post);
                break;
            }
        }
        
        if(!$found)
        {
            $this->sortRoute("404", $get);   
        }
    }
}