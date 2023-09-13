<?php 
namespace App\Controllers;
use App\Controllers\MainController;

class ContactController extends MainController {
    
      public function renderContact(): void 
      {
           if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["btnForm"])) {
                $this->EnvoiForm();
            }
    } 
    $this->render();
    
      }
                
                public function EnvoiForm (){
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];


    $destinataire = 'jb@mail.com';
    $sujet = '';

    // Envoi de l'e-mail
    if (mail($destinataire, $sujet,)) {
        $this->data[] = "Le message a été envoyé avec succès.";
    } 
    else {
        echo 'Une erreur est survenue lors de l\'envoi du message.';
    }
}

}
}
?>