<?php
/**
 * @author : Gaellan
 */

class Router {

    private function parseRequest(string $request)
    {
        $route = [];

        $routeData = explode("/", $request);

        $route["path"] = "/".$routeData[1];
        
        //If we have 2 slugs or more 
        if(count($routeData) > 2)
        {
            
            for ($i=2,$max=count($routeData)-1;$i<=$max;$i++)
            {
                // We check if the last slug ...
                if($i==$max)
                {
                    // ... is a numeric value
                    if(is_numeric($routeData[$i]))
                    { 
                        // if it is, then it is a parameter
                        $route["parameter"] = $routeData[$i];
                    }
                    else
                    {
                        // if not, then it is a path and there is no parameter
                        $route["path"]=$route["path"]."/".$routeData[$i];
                        $route["parameter"] = null;
                    }
                }
                else
                {
                    //if it isn't the last slug, then we add it to the path
                    $route["path"]=$route["path"]."/".$routeData[$i];
                }
            }
        }
        else
        {
            $route["parameter"] = null;
        }
        
        return $route;
    }

    public function route(array $routes, string $request)
    {
        $requestData = $this->parseRequest($request);

        $routeFound = false;

        foreach($routes as $route)
        {
            $controller = $route["controller"];
            $method = $route["method"];
            $parameter = $route["parameter"];

            if($route["path"] === $requestData["path"])
            {
                if($route["parameter"] && $requestData["parameter"] !== null)
                {
                    $routeFound = true;

                    $ctrl = new $controller(); //magic method
                    $ctrl->$method($requestData["parameter"]);
                }
                else if(!$route["parameter"] && $requestData["parameter"] === null)
                {
                    $routeFound = true;

                    $ctrl = new $controller();
                    $ctrl->$method($_GET, $_POST);
                    }
            }
        }

        if(!$routeFound)
        {
            throw new Exception("Route not found", 404);
        }
    }
}
