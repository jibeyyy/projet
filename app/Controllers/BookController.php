<?php

namespace App\Controllers;
use App\Controllers\MainController;
use App\Models\BookModel;

class BookController extends MainController{

    public function renderBook(){ // affiche le livre a exposer
           
         $bookModel = new BookModel();     
        // il transmet les data au MainController              
        $this->data =  $bookModel->getBookById($this->subPage);  
        // Puis il appelle le render de MainController pour construire la page      
        $this->render();
    }
}
?>