<?php

namespace App\Controllers;


class MainController {
   
    protected string $view;

    protected $subPage;
    
    protected $data;

    protected string $viewType = 'front';


    public function render() {
              

        $base_uri = explode('/public/', $_SERVER['REQUEST_URI']);
    
        $data = $this->data;
        require __DIR__ . '/../views/' . $this->viewType . '/layouts/header.phtml';
        require __DIR__ . '/../views/' . $this->viewType . '/partials/' . $this->view . '.phtml';
        require __DIR__ . '/../views/' . $this->viewType . '/layouts/footer.phtml';
  
        
    }
    
protected function checkUserAuthorization(int $role): void
{
 
    
    if (isset($_SESSION['userObject'])) {
        $currentUser = $_SESSION['userObject'];
        $currentUserRole = $currentUser->getRole();
        
        if ($currentUserRole <= $role) {
            header('Location: /public/admin'); // Redirige vers la page d'administration
            exit();
        } else {
            http_response_code(403);
            $this->view = '403';
            $this->render();
            exit();
        }
    } else {
        $redirect = explode('/public/', $_SERVER['REQUEST_URI']);
        header('Location: ' . $redirect[0] . '/public/home');
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
     public function getTypeView(): string {
        return $this->typeView;
    }
    
 
    public function setTypeView(string $typeView): void {
        $this->view = $typeView;
    }
    
    
}