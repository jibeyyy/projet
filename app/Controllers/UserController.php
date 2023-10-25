<?php
namespace App\Controllers;
use App\Controllers\MainController;
use App\Models\UserModel;

class UserController extends MainController {
    
    public function renderUser() {
        if($this->view === 'user'){
                $this->autorizeUser(3);  
        }
        if (isset($_POST["logout"])) {
            $this->logout();
        } else {
            if (isset($_POST["registerForm"])) {
                $this->register();
            } elseif (isset($_POST["loginForm"])) {
                $this->login();
            }
        }
    $this->render();

}

    public function register() {
        $error = 0;
        $name = $_POST['username'];
        $firstName = $_POST['firstName'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        
        if (strlen($password) < 7) {
            $error = 1;
            $this->data[] = '<div class="alert" role="alert">Le mot de passe doit contenir au moins 7 caractères.</div>';
        }
        
        if ($error === 0) {
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $user = new UserModel();
            $user->setEmail($email);
            $user->setAddress($address);
            $user->setPassword($hashPassword);
            $user->setName($name);
            $user->setFirstName($firstName);
            $user->setRole(3);
            
            if ($user->checkEmail()) {
                $error = 1;
                $this->data[] = '<div class="alert role="alert">Cet email est déjà pris, veuillez en choisir un autre.</div>';
            }
            
            if ($error === 0) {
                if ($user->registerUser()) {
                    $this->data[] =  '<div class="succe" role="alert">Enregistrement réussi, vous pouvez maintenant vous connecter</div>';
                } else {
                    $this->data[] = '<div class="alert" role="alert">Il y a eu une erreur lors de l\'enregistrement</div>';
                }
            }
        }
    }

public function login(): void
{
    $errors = 0;
    $user = new UserModel();
    $user = $user->getUserByEmail($_POST['email']);
    
    if (is_null($user)) {
        $errors = 1;
    } else {
        if (password_verify($_POST['password'], $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user_role'] = $user->getRole();
            echo '<div class="succe" role="alert">connexion réussie !</div>';
            
            $base_uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
            
            if ($user->getRole() < 3) {
                header('Location:' . $base_uri[0] . 'admin');
                 echo '<div class="succe" role="alert">connexion réussie !</div>';
                 
            } elseif ($user->getRole() >= 3) {
                header('Location:' . $base_uri[0] . 'user');
                 echo '<div class="succe" role="alert">connexion réussie !</div>';
            }
        } else {
            $errors = 1;
            echo '<div class="alert" role="alert">Email ou mot de passe incorrect</div>';
        }
    }
}


 // déconexion d'un utilisateur
 public function logout(): void 
 {  
        unset($_SESSION['user-id']);
        // pour détruire la session 
        session_destroy();
        // création de l'url de redirection
        $base_uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
        
        header('Location:' . $base_uri[0] . 'home');
    }
 
}