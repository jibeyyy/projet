<?php

namespace App\Controllers;
use App\Controllers\MainController;
use PDO; 
use App\Utils\DataBase; 

class ResetPassword extends MainController { 
    
     public function __construct(){
        // on modifie la view pour 404
        $this->view = 'reset';
        $this->render();
    }
    
    public function initiatePasswordReset() { // Méthode pour initier la réinitialisation du mot de passe

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST["email"];
            
            // Vérifier si l'e-mail existe dans la base de données
            if ($this->checkEmail($email)) {
                // Générer un jeton aléatoire
                $resetToken = $this->generateRandomToken();
                
                // Mettre à jour le jeton dans la base de données
                $this->updateResetToken($email, $resetToken);
                
                // Envoi de l'e-mail de réinitialisation
                $resetLink = "https://votresite.com/reset_password.php?token=" . $resetToken;
                $to = $email;
                $subject = "Réinitialisation de votre mot de passe";
                $message = "Cliquez sur le lien suivant pour réinitialiser votre mot de passe : $resetLink";
                $headers = "From: exemple@exemple.fr\r\n" .
                           "Reply-To: exemple@example.com\r\n" .
                           "X-Mailer: PHP/" . phpversion();
                mail($to, $subject, $message, $headers);
                
                echo "Un e-mail de réinitialisation a été envoyé à votre adresse e-mail.";
            } else {
                echo "L'adresse e-mail n'est pas valide.";
            }
        }
    }

    public function checkEmail($email) { // vérification de l'email d'un utilisateur 
    //pour envoyé un mail de récuperation
        $pdo = DataBase::connectPDO();

        $sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
       
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $email);
        $query->execute();
       
        $isMail = $query->fetchColumn();
        
        return $isMail > 0;
    }

    public function generateRandomToken($length = 20) { // création mot unique pour réinitialisé le mot de passe
    
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $token = '';
        for ($i = 0; $i < $length; $i++) {
            $token .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $token;
    }

    public function updateResetToken($email, $token) { // mise a jour des information du mot de passe dans la BDD
        $pdo = DataBase::connectPDO();

        $sql = "UPDATE `user` SET `reset_token` = :token WHERE `email` = :email";
       
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $email);
        $query->bindParam(':token', $token);
        $query->execute();
    }
}

$resetPasswordController = new ResetPassword();  //appel d'une instanciation d'une initialiseation de mot de passe
$resetPasswordController->initiatePasswordReset();

?>
