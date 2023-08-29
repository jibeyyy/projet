<?php

namespace App\Controllers;
use App\Controllers\MainController;
use App\Models\BookModel;

  class UserController extends MainController {
    
    public function renderUser() {
      
        if ($this->view === 'logout') {
           
            $this->logout();
        } else {
            
            if ($_SERVER["REQUEST_METHOD"] === "POST") {
                // si le formulaire soumis est registerForm
                if (isset($_POST["registerForm"])) {
                    // on appel la méthode register
                    $this->register();
                    // sinon si le formulaire soumis est LoginForm
                } elseif (isset($_POST["loginForm"])) {
                    // on appel la méthode Login
                    $this->login();
                }
            }
        }
        // dans tous les cas on construit la page
        $this->render();
    }
   
  public function register() { // enregistrement d'un utilisateur
     
      if ($_SERVER['REQUEST_METHOD']=== 'POST') {
          
           $error = 0;
           $username = $_POST['username'];
           $mail = $_POST['email'];
           $password = $_POST['password'];
           
           if (strlen($password) < 8) {
            // C'est une erreur
            $errors = 1;
            // on stocke dans la propriété data le message d'erreur que l'on va afficher dans la vue ensuite
            $this->data[] = '<div class="alert alert-danger" role="alert">Le mot de passe doit contenir au moins 8 caractères.</div>';
        }

        // S'il n'y a pas d'erreurs
        if ($errors < 1) {
            // on hash le mot de passe
            $hashPassword = password_hash($password, PASSWORD_DEFAULT);

            // on créer une nouvelle instance de UserModel
            $user = new UserModel();
            // On alimente les propriétés grâce aux setters
            $user->setEmail($email);
            $user->setPassword($hashPassword);
            $user->setName($name);
            $user->setRole(3);

            // on vérifie si un utilisateur avec le même email existe 
            if ($user->checkEmail()) {
                // Si c'est le cas c'est une erreur
                $errors = 1;
                $this->data[] = '<div class="alert alert-danger" role="alert">Cet email est déjà pris, veuillez en choisir un autre.</div>';
            }
            // s'il n'y a toujours pas d'erreur, c'est tout bon !
            if ($errors < 1) {
                // on peut enregistrer l'utilisateur en appellant la méthode registerUser, elle renvera true ou false
                if ($user->registerUser()) {
                    // si elle renvoie true, on stocke dans data un message de validation
                    $this->data[] =  '<div class="alert alert-success" role="alert">Enregistrement réussi, vous pouvez maintenant vous connecter</div>';
                } else {
                    // sinon on on stocke dans data un message d'erreur
                    $this->data[] = '<div class="alert alert-danger" role="alert">Il y a eu une erreur lors de l\enregistrement</div>';
                }
            }
        }
      }
  }
  
public function login() {  //connection d'un utilisateur
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Valide et filtre les données POST
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'];

            if (!$email || empty($password)) {
                $this->handleLoginError();
                return;
            }

            $userModel = new UserModel();
            $user = $userModel->getUserByEmail($email);

            if ($user && password_verify($password, $user->getPassword())) {
                $this->handleSuccessfulLogin($user);
            } else {
                $this->handleLoginError();
            }
        } else {
            require_once 'views/user/partials/login.php';
        }
    }

    private function handleLoginError() {  // mauvaise conection d'un utilisateur
        // Redirige avec un message d'erreur
        header('Location: /login?error=1');
        exit();
    }

    private function handleSuccessfulLogin($user) { // connection réussi d'un utilisateur
        $_SESSION['userObject'] = $user;

        $message = '<div class="alert alert-success" role="alert">Connexion réussie ! Votre compte doit être modifié par un admin pour que vous ayez accès à l\'administration</div>';
        $this->data[] = $message;

        $base_uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
        $destination = ($user->getRole() < UserRoles::ADMIN) ? 'admin' : 'profil';
        
        // Redirection échappée
        header('Location:' . htmlspecialchars($base_uri[0] . $destination));
        exit();
    }


 private function logout(){  // déconexion d'un utilisateur
        
        unset($_SESSION['userObject']);
        // pour détruire la session 
        session_destroy();
        // création de l'url de redirection
        $base_uri = explode('index.php', $_SERVER['SCRIPT_NAME']);
        // on redirige vers la home
        header('Location:' . $base_uri[0] . 'home');
    }
  
}
