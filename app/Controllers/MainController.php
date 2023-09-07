<?php

namespace App\Controllers;


class MainController {
    // propriété stockant la vue
    protected string $view;
    // propriété stockant la sous-page
    protected $subPage;
    // propriété stockant les données de la page
    protected $data;
    // propriété stockant le type de vue (admin/front)
    protected string $viewType = 'front';

    public function render() {
    //     // ici on explode $_SERVER['request_uri]. ça va séparer l'url à partir du dossier /public/ 
    //     // ça va créer un tableau contenant au premier index la première partie de l'url (celle qui nous sert) et au second index la partie dont on ne veut pas
    //     //  cette url va nous servir pour les liens de la barre de nav
    //     // faites un var_dump de $base_uri pour vraiment bien comprendre ce qui est créé !            

        $base_uri = explode('/public/', $_SERVER['REQUEST_URI']);
       
    //     // Dans tous les cas, on alimente la variable $data avec les données de la propriété $this->$data
    //     // $this->data est alimentée dans chacun des controller enfant et sera utilisée dans les vues
    //     // Si il n'y a pas besoin de data dans un controller, elle vaudra null et ne sera pas utilisée dans la vue
        $data = $this->data;
    //     // On construit la page 
        require __DIR__ . '/../views/' . $this->viewType . '/layouts/header.phtml';
        require __DIR__ . '/../views/' . $this->viewType . '/partials/' . $this->view . '.phtml';
        require __DIR__ . '/../views/' . $this->viewType . '/layouts/footer.phtml';
    }
    
protected function checkUserAuthorization(int $role): bool
    {
        // S'il y'a une session user
        if (isset($_SESSION['userObject'])) {
            // on stocke les données de la session dans une variable
            $currentUser = $_SESSION['userObject'];
            //  on récupère le rôle
            $currentUserRole = $currentUser->getRole();
            
            if ($currentUserRole <= $role) {
              header('Location: ' . $redirect[0] . '/public/admin');
               
            } else {
                // sinon, on renvoie un code d'erreur 403
                http_response_code(403);
                // on alimente la propriété view avec la vue 403
                $this->view = '403';
                // on construit la page
                $this->render();
                // on arrête le script
                exit();
            }
        } else {
            
            $redirect = explode('/public/', $_SERVER['REQUEST_URI']);
            // on redirige vers la page de connexion
            header('Location: ' . $redirect[0] . '/public/login');
            // on arrête le script
            exit();
        }
    }
    public function getView(): string {
        return $this->view;
    }
    
 
    public function setView(string $view): void {
        $this->view = $view;
    }

    public function getSubPage(): string {
        return $this->subPage;
    }

    public function setSubPage(?string $value): void {
        $this->subPage = $value;
    }
    
}