<?php
namespace App\Controllers;

use App\Controllers\MainController;
use App\Models\BookModel;

class BookController extends MainController {


    public function renderPost(): void
    {
        // on alimente la propriété data avec le livre 
        $this->data =  BookModel::getBookById($this->subPage);
        // on construit la page
        $this->render();
    }
}