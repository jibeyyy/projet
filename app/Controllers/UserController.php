<?php
namespace App\Controllers;
use App\Controllers\MainController;
use App\Models\UserModel;

class UserController extends MainController {
    
    public function renderUser() {
        if ($this->view === 'logout') {
            $this->logout();
        } else {
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                if (isset($_POST["registerForm"])) {
                    $this->register();
                } elseif (isset($_POST["loginForm"])) {
                    $this->login();
                }
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
            $this->data[] = '<div class="alert alert-danger" role="alert">Le mot de passe doit contenir au moins 8 caractères.</div>';
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
                $this->data[] = '<div class="alert alert-danger" role="alert">Cet email est déjà pris, veuillez en choisir un autre.</div>';
            }
            
            if ($error === 0) {
                if ($user->registerUser()) {
                    $this->data[] =  '<div class="alert alert-success" role="alert">Enregistrement réussi, vous pouvez maintenant vous connecter</div>';
                } else {
                    $this->data[] = '<div class="alert alert-danger" role="alert">Il y a eu une erreur lors de l\'enregistrement</div>';
                }
            }
        }
    }
public function login(): void
{
    $errors = 0;
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = UserModel::getUserByEmail($email, $password);

    if ($user === null) {
        
        $errors = 1;
        echo 'erreur connexion';
        }
        else if ($errors = 0 && $user->getRole < 3){
           header('Location:' . $base_uri[0] . 'admin');
        }
     else {
        header('Location:' . $base_uri[0] . 'home');
       
    }
}

 // déconexion d'un utilisateur
 public function logout(): void 
 {  
        unset($_SESSION['userObject']);
        // pour détruire la session 
        session_destroy();
        // création de l'url de redirection
        $base_uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
        // on redirige vers la home
        header('Location:' . $base_uri[0] . 'home');
    }
 } 
