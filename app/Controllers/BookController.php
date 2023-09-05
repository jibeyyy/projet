<?php

namespace App\Controllers;
use App\Controllers\MainController;
use App\Models\BookModel;

class BookController extends MainController {

   
    public function renderBook() {
        $bookModel = new BookModel();

        // Vérifier si l'identifiant est valide avant d'appeler la méthode
        $bookId = $this->subPage; // Assurez-vous que $this->subPage contient l'identifiant

        if (is_numeric($bookId)) { // Vérifier si c'est un nombre
            $bookId = (int) $bookId; // Convertir en int si c'est un nombre
            $this->data = $bookModel->getBookById($bookId);
            $this->render();
        } else {
           echo 'livre non trouvé';
        }
    }
}
