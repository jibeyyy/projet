<?php

namespace App\Controllers;
use App\Controllers\MainController;

use App\Models\BookModel;

class AdminController extends MainController { // connexion à l'administrateur avec autorisation a acceder au compte
    
    public function renderAdmin(): void
    {
        $this->viewType = 'admin';
        $this->autorizeUser(1);
       
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["insertBook"])) {
                $this->addBook();
            }
            if (isset($_POST['deleteBook'])) {
                $this->removeBook();
            }
            if (isset($_POST['updateBook'])) {
              
                $this->updateBook();
            }
        }

        
       
        if (isset($this->subPage)) {
            
            $this->view = $this->subPage;
         
            if ($this->view === 'update') {
                
                if (isset($_GET['id'])) {
                                  
                    $book = BookModel::getBookById($_GET['id']);
                 
                    if (!$book) {
                       
                        $this->data['error'] = '<div class="alert" role="alert">L\'article n\'existe pas</div>';
                    } else {
                       
                        $this->data['book'] = $book;
                      
                    }
                }
            }
        } 
        
        $bookModel = new BookModel();
        $books = $bookModel->getAllBooks(); 
        $this->data['books'] = $books;
        $this->render();
    }
    
    //méthode pour ajouter un article au site
    public function addBook(): void    
    {

        // filter_input est une fonction PHP
        // elle récupère une variable externe d'un champs de formulaire et la filtre
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $resume = filter_input(INPUT_POST, 'resume', FILTER_SANITIZE_SPECIAL_CHARS);
        $img = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_URL);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
        $stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_SPECIAL_CHARS);


        $bookModel = new BookModel();
        
        $bookModel->setName($name);
        $bookModel->setResume($resume);
        $bookModel->setImg($img);
        $bookModel->setPrice($price);
        $bookModel->setStock($stock);

        // on déclenche l'instertion d'article dans une conditions car PDO va renvoyer true ou false
        if ($bookModel->insertBook()) {
            // donc si la requête d'insertion s'est bien passée, on renvoie true et on stocke un message de succès dans la propriété data
            $this->data[] = '<div class="succe" role="alert">Article enregistré avec succès</div>';
        } else {
            // sinon, stocke un message d'erreur
            $this->data[] = '<div class="alert" role="alert">Il s\'est produit une erreur</div>';
        }
    }

    public function updateBook(): void // mise a jour d'un article en vente
    {

        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $resume = filter_input(INPUT_POST, 'resume', FILTER_SANITIZE_SPECIAL_CHARS);
        $price = filter_input(INPUT_POST, 'price', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
        $img = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_URL);

        $bookModel = new BookModel();
        $bookModel->setId($id);
        $bookModel->setName($name);
        $bookModel->setResume($resume);
        $bookModel->setImg($img);
        $bookModel->setPrice($price);
        
        
        if ($bookModel->updateBook()) {
            $this->data['infos'] = '<div class="succe" role="alert">Article enregistré avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert" role="alert">Il s\'est produit une erreur</div>';
        }
    }

    // méthode de suppresion d'un article
    public function removeBook(): void
    {
        // récupération et filtrage du champs 
        $bookId = filter_input(INPUT_POST, 'bookid', FILTER_SANITIZE_SPECIAL_CHARS);

        if (BookModel::deleteBook($bookId)) {
            $this->data['infos'] = '<div class="succe" role="alert">Article supprimé avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert" role="alert">Il s\'est produit une erreur</div>';
        }
    }
}


?>