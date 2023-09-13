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

    public static function addToCart($name, $price, $quantity) {
        // Vérifiez si les données sont valides (par exemple, si le nom est non vide, le prix est un nombre positif, etc.)
        // Effectuez également des validations supplémentaires selon vos besoins.
        
        $cartItem = [
            'name' => $name,
            'price' => $price,
            'quantity' => $quantity
        ];

        // Utilisation des sessions pour stocker le panier
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Ajoutez l'élément au panier
        $_SESSION['cart'][] = $cartItem;
    }

    public function paner() {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["paner"])) {
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
            $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
            $quantity = filter_input(INPUT_POST, 'quantity', FILTER_VALIDATE_INT);
            
            if ($name && $price && $quantity && $price > 0 && $quantity > 0) {
                // Appel à la fonction d'ajout au panier
                $this->addToCart($name, $price, $quantity);

                // Mettez à jour le stock dans la base de données
                $this->updateStock($name, $quantity);
            } 
        }
    }

    public function updateStock($name, $quantity) {
        // Récupérez le modèle de base de données pour les livres
        $bookModel = new BookModel();
        
        // Récupérez le stock actuel
        $currentStock = $bookModel->getStockByName($name);

        if ($currentStock !== null && $currentStock >= $quantity) {
            // Calculez le nouveau stock
            $newStock = $currentStock - $quantity;

            // Mettez à jour le stock dans la base de données
            $bookModel->updateStockByName($name, $newStock);
        }
        else {
            echo ' stock insufisant';
        }
    }
}
