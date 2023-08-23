<?php
require __DIR__.'/../vendor/autoload.php';
// session_start(); // permet douvrire une session quand l'utilisateur se connect

 $base_uri = explode('/', $_SERVER['REQUEST_URI']);

//  Variable contenant les routes dispo
// Cette variable contient pour chaque page son controller à appeler
// ainsi que sa méthode à appeler

const AVAIABLE_ROUTES = [
    'home'=>'HomeController',

    'shop'=>'MainController',
    
    'contact'=> 'MainController',
    
    'login'=> 'UserController',
   
    'logout'=> 'UserController',
        
    'register'=> 'UserController',
    
    'admin'=> 'AdminController',
    
    '404'=> 'ErrorController',
    
    'payment'=> 'PaymentController',
];

//initiatilisation des variables 
$page = 'home'; // la variable avec la valeur home
$controller;

$itemId=null;
// s'il y a un param GET page, on le stocke
//dans le parametre page sinon on redirige vers home
if(isset($_GET['page']) && !empty($_GET['page'])){        
    $page = $_GET['page'];
      if(!empty($_GET['subpage'])){
        $subPage = $_GET['subpage'];
        
    }

    
    // Si on trouve en plus un param id dans l'url on le stocke
    // dans la variable $itemId;
    if(!empty($_GET['id'])){   // on vérifi si l'identifiant est pas vide 
        $itemId = $_GET['id'];
}else{
    $page = 'home';  // si il y a pas d'id on est rediriger ver la page home
}
// Si la page demandée fait partie de notre tableau de routes, on 
// la stocke dans la variable controller
// sinon on redirige vers le controller ErrorController
if(array_key_exists($page,AVAIABLE_ROUTES)){  //si la clef existe par rapoort au chemin des routes
    // on stocke dans la variable, le controller de la page demandée
    $controller = AVAIABLE_ROUTES[$page]['controller'];
    // on stocke dans la variable, la méthode (l'action) de la page demandée, l'action en reference au tableau des route
    $controllerAction = AVAIABLE_ROUTES[$page]['action'];
}else{
    $controller = 'ErrorController';
}

$namespace = "App\Controllers";//on met le chemin de l'autoloader dans une variable
$controllerClassName = $namespace . '\\' . $controller; // on concatene le chemin de la base de donner au tableau des routes
// on fait une nouvelle instance du controller de la page demandée
// $pageNameController = $namespace.$controller;
$pageController = new $controllerClassName(); // on instanci 
var_dump($namespace);
// on utilise son setter pour communiquer à la propriété $view la vue correspondante
$pageController->setView($page);
// on utilise son setter pour communiquer à la propriété $id du controller
// $pageController->setId($itemId);
// on appelle la bonne méthode en fonction de la page demandée
$pageController->setSubPage($subPage);
$pageController->$controllerAction();
}
?>