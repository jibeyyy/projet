<?php

namespace App\Controllers;
use App\Controllers\MainController;
use App\Models\BookModel;

class BookController extends MainController {

   
    public function renderBook() {
    $bookModel = new BookModel();
    $books = $bookModel->getAllBooks(); 
    
    
    $this->data = $books;

    $this->render();
}
}

