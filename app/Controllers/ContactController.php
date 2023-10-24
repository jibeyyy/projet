<?php 
namespace App\Controllers;
use App\Controllers\MainController;

class ContactController extends MainController {
    
      public function renderContact(): void 
      {
       

// Récupérer les données du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST"){
     if (isset($_POST["btnForm"])) {
                $this->insertMessage(); 
}

        $contactModel = new ContactModel();
        $message = $contactModel->getMessages(); 
        $this->data['message'] = $message;
        $this->render();

}
}
 public function addMessage() {
    $contactModel = new ContactModel();

    $lastName = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
    $firstName = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_URL);
    $msg = filter_input(INPUT_POST, 'msg', FILTER_SANITIZE_SPECIAL_CHARS);

    $contactModel->setLastName($lastName);
    $contactModel->setFirstName($firstName);
    $contactModel->setEmail($email);
    $contactModel->setMsg($msg);

    if ($contactModel->insertMessage()) {
        $this->data[] = '<div class="succe" role="alert">Message envoyé avec succès</div>';
    } else {
        $this->data[] = '<div class="alert" role="alert">Il s\'est produit une erreur</div>';
    }
}
}