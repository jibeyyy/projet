<?php
require __DIR__.'/../vendor/autoload.php';
// session_start(); // permet douvrire une session quand l'utilisateur se connect

 $base_uri = explode('/', $_SERVER['REQUEST_URI']);

//  Variable contenant les routes dispo
// Cette variable contient pour chaque page son controller à appeler
// ainsi que sa méthode à appeler

const AVAIABLE_ROUTES = [
    'home' => ['controller' => 'MainController', 'action' => 'render'],
    'login' => ['controller' => 'UserController', 'action' => 'renderUser'],
    'logout' => ['controller' => 'UserController', 'action' => 'renderUser'],
    'registerUser' => ['controller' => 'UserController', 'action' => 'register'],
    'admin' => ['controller' => 'AdminController', 'action' => 'renderAdmin'],
    '404' => ['controller' => 'ErrorController', 'action' => 'render'],
    'shop' => ['controller'=> 'BookController', 'action' =>'renderBook']
];

$page = 'home';
$controller;
$subPage = null;
$itemId=null;
// s'il y a un param GET page, on le stocke
//dans le parametre page sinon on redirige vers home
if(isset($_GET['page']) && !empty($_GET['page'])){        
    $page = $_GET['page'];
      if(!empty($_GET['subpage'])){
        $subPage = $_GET['subpage'];
        
    }
}else{
    $page = 'home';  // si il y a pas d'id on est rediriger ver la page home
}
    //////// routeur reset password////////
//$route = $_GET['route']; // Supposons que vous utilisez un paramètre GET pour le routage
/*
if ($route == 'reset-password') {
    $resetPasswordController = new ResetPassword();
    $resetPasswordController->initiatePasswordReset();
} elseif ($route == 'autre-page') {


/////////a vérifiééé////////


    if(!empty($_GET['id'])){   // on vérifi si l'identifiant est pas vide 
        $itemId = $_GET['id'];
}else{
    $page = 'home';  // si il y a pas d'id on est rediriger ver la page home
}*/

if(array_key_exists($page,AVAIABLE_ROUTES)){ 
    $controller = AVAIABLE_ROUTES[$page]['controller'];
    $controllerAction = AVAIABLE_ROUTES[$page]['action'];
}else{
    $controller = 'ErrorController';
}

$namespace = "App\Controllers";//on met le chemin de l'autoloader dans une variable
$controllerClassName = $namespace . '\\' . $controller; // on concatene le chemin de la base de donner au tableau des routes

$pageController = new $controllerClassName();
// on utilise son setter pour communiquer à la propriété $view la vue correspondante
$pageController->setView($page);
$pageController->setSubPage($subPage);
$pageController->$controllerAction();

?>