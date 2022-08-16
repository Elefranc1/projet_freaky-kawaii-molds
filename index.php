<?php
/**
 * @author : Gaellan
 */
session_start();
require "autoload.php";


//TEST

// if(!empty($_POST)){
//     var_dump($_POST);
// }

//END TEST

try {

    $router = new Router();

    if(isset($_GET['path']))
    {
        $request = "/".$_GET['path'];
    }
    else
    {
        $request = "/";
    }

    $router->route($routes, $request);
}
catch(Exception $e)
{
    if($e->getCode() === 404)
    {
        require "./templates/404.phtml";
    }
}