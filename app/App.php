<?php

namespace SierraSql;

use \Symfony\Component\HttpFoundation\Request;
use \Symfony\Component\HttpFoundation\Response;
use \League\Route\RouteCollection;
use SierraSql\DbConnection;
use \Noodlehaus\Config;

class App 
{
    protected   $router,
                $dispatcher,
                $db;
                
    public function __construct($production = true, $queryLogging = false)
    {
        if(!isset($this->db)) {
             $this->db = DbConnection::connect($production);
        }

        if(!isset($this->router)) {
            $this->router = $this->setupRouter();
        }

        if(!$production) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1'); 
        }

        if($queryLogging) {
            $this->db->logQuery();
        }
    }

    private function setupRouter()
    {
        $router = new \League\Route\RouteCollection;
        $routes = Config::load('../app/config/routes.php');
        $routes = $routes['routes'];
        $this->setUpRoutes($routes, $router);   

        return $router;
    }
    
    private function setUpRoutes($routes, $router)
    {
        foreach($routes as $route) {
            $router->addRoute($route['verb'], $route['path'], $route['action']);
        }
    }
    
    public function getDb()
    {
        return $this->db;
    }

    public function dispatch() 
    {
        $this->dispatcher = $this->router->getDispatcher();
        $request = Request::createFromGlobals();
        
        $response = $this->dispatcher->dispatch($request->getMethod(), $request->getPathInfo());
        
        $response->send();        
    }
}
