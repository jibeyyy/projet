<?php

namespace App\Controllers;
use App\Controllers\MainController;

use App\Models\BookModel;

class AdminController extends MainController { // connexion à l'administrateur avec autorisation a acceder au compte
    
    public function renderAdmin(): void
    {
    
        $this->checkUserAuthorization(1); 
       
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            // et si le formulaire est addPostForm
            if (isset($_POST["addBookForm"])) {
                //  on lance la méthode d'ajout d'article
                $this->addBook();
            }
            // si le formulaire est deletePostForm
            if (isset($_POST['deleteBookForm'])) {
                //  on lance la méthode de suppression d'article
                $this->removeBook();
            }
            // si le formulaire est updatePostForm
            if (isset($_POST['updateBookForm'])) {
                //  on lance la méthode de mise à jour d'article
                $this->updateBook();
            }
        }

        // La vue à rendre est admin. On la passe dans notre propriété viewType du controller parent
        $this->viewType = 'admin';
        // On vérifie si subPage existe
        if (isset($this->subPage)) {
            // si subPage existe, on modifie la propriété viewType du controller parent
            $this->view = $this->subPage;
            // si la view demandée === update
            if ($this->view === 'update') {
                // On doit récupérer l'id de l'article à mettre à jour
                if (isset($_GET['id'])) {
                    // on récupère l'article via son id grâce à la méthode statique getPostById                    
                    $book = BookModel::getBookById($_GET['id']);
                    // Si l'article la méthode est l'inverse de true
                    if (!$book) {
                        // on stocke un message d'erreur dans la propriété data du controller parent
                        $this->data['error'] = '<div class="alert alert-danger" role="alert">L\'article n\'existe pas</div>';
                    } else {
                        //sinon on sotcke dans la propriété data du controller parent l'article récupéré
                        $this->data['Book'] = $Book;
                    }
                }
                // 
            }
        } else {
         
            $this->data['Book'] = BookModel::getBook();
        }

        $this->render();
    }
    
    //méthode pour ajouter un article au site
    public function addBook(): void    
    {

        // filter_input est une fonction PHP
        // elle récupère une variable externe d'un champs de formulaire et la filtre
        $title = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
        $resume = filter_input(INPUT_POST, 'resume', FILTER_SANITIZE_SPECIAL_CHARS);
        $img = filter_input(INPUT_POST, 'img', FILTER_SANITIZE_URL);
        $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);


        $bookModel = new BookModel();
        // puis on utilise les setters pour ajouter les valeurs au propriétés privée du postModel
        $bookModel->setName($name);
        $bookModel->setResume($resume);
        $bookModel->setImg($img);
        $bookModel->setPrice($price);

        // on déclenche l'instertion d'article dans une conditions car PDO va renvoyer true ou false
        if ($bookModel->insertBook()) {
            // donc si la requête d'insertion s'est bien passée, on renvoie true et on stocke un message de succès dans la propriété data
            $this->data[] = '<div class="alert alert-success" role="alert">Article enregistré avec succès</div>';
        } else {
            // sinon, stocke un message d'erreur
            $this->data[] = '<div class="alert alert-danger" role="alert">Il s\'est produit une erreur</div>';
        }
    }

    public function updateBook(): void // mise a jour d'un article en vente
    {

        $id = filter_input(INPUT_POST, 'Id', FILTER_SANITIZE_NUMBER_INT);
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
            $this->data['infos'] = '<div class="alert alert-success" role="alert">Article enregistré avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert alert-danger" role="alert">Il s\'est produit une erreur</div>';
        }
    }

    // méthode de suppresion d'un article
    public function removeBook(): void // suppression d'un article en vente
    {
        // récupération et filtrage du champs 
        $bookId = filter_input(INPUT_POST, 'Id', FILTER_SANITIZE_SPECIAL_CHARS);

        if (BookModel::deleteBook($bookId)) {
            $this->data['infos'] = '<div class="alert alert-success d-inline-block mx-4" role="alert">Article supprimé avec succès</div>';
        } else {
            $this->data['infos'] = '<div class="alert alert-danger" role="alert">Il s\'est produit une erreur</div>';
        }
    }
}


?>