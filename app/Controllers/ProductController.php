<?php

class ProductController {
    public function displayProduct($productId) {
        
        $product = ProductModel::getProductById($productId); // recuperation du formulaire d'ajout au panier

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['quantity'])) {
            // Ajouter l'article au panier
            $quantity = intval($_POST['quantity']);
            Cart::addItem($product, $quantity);
        }

        // Charger la vue pour afficher l'article
        include 'views/shop.phtml';
    }
}
