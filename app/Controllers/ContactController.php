<?php 
namespace App\Controllers;
use App\Controllers\MainController;

class ContactController extends MainController {
    
      public function renderContact(): void 
      {
       

// Récupérer les données du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST"){
$nom = $_POST['lastName'];
$prenom = $_POST['firstName'];
$email = $_POST['mail'];
$message = $_POST['msg'];
}

$this->render();

}
}


?>