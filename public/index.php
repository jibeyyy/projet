<?php
require __DIR__.'/../vendor/autoload.php';
session_start();
 $base_uri = explode('/', $_SERVER['REQUEST_URI']);


const AVAILABLE_ROUTES = [
    'home' => ['controller' => 'MainController', 'action' => 'render'],
    'contact' => ['controller' => 'ContactController','action'=> 'renderContact'],
    'login' => ['controller' => 'UserController', 'action' => 'renderUser'],
    'logout' => ['controller' => 'UserController', 'action' => 'renderUser'],
    'register' => ['controller' => 'UserController', 'action' => 'renderUser'],
    'forgot-password'=> ['controller' => 'MainController', 'action'=> 'render'],
    'admin' => ['controller' => 'AdminController', 'action' => 'renderAdmin'],
    '404' => ['controller' => 'ErrorController', 'action' => 'render'],
    'shop' => ['controller'=> 'BookController', 'action' =>'renderBook'],
    'user' => ['controller'=> 'UserController', 'action' => 'renderUser'],
    '403'=> ['controller'=> 'MainController', 'action' => 'render'],
    
];

$page = 'home';
$controller='';
$subPage = null;
$itemId=null;

           if(isset($_GET['page']) && !empty($_GET['page'])){        
               $page = $_GET['page'];
                
                  if(!empty($_GET['subpage'])) {
                      $subPage = $_GET['subpage'];
    }
}
else{
    $page = 'home'; 
}

if (array_key_exists($page, AVAILABLE_ROUTES)) {
    $controller = AVAILABLE_ROUTES[$page]['controller'];
    $controllerAction = AVAILABLE_ROUTES[$page]['action'];
} else {
    $controller = 'ErrorController';
     $controllerAction = 'render';
}

$namespace = "App\Controllers";
$controllerClassName = $namespace . '\\' . $controller;

$pageController = new $controllerClassName();
$pageController->setView($page);
$pageController->setSubPage($subPage);
$pageController->$controllerAction();
?>