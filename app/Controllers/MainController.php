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
    
protected function autorizeUser(int $role): void
{

    $redirect = explode('/public/', $_SERVER['REQUEST_URI']);
    if (isset($_SESSION['user_id'])) {
        $currentUser = $_SESSION['user_id'];
        $currentUserRole = $_SESSION['user_role'];
        
        if ($currentUserRole != 1 && $this->view === 'admin') {
            header('Location: ' . $redirect[0] . '/public/user');
           exit();
        }

    } else {
        header('Location: ' . $redirect[0] . '/public/login');
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