<?php 
class ProductModel {
    public static function getBookById($productId) {
        $pdo = DataBase::connectPDO(); // Récupérer la connexion PDO
        $query = $pdo->prepare('SELECT * FROM Book WHERE id = :id');
        $query->bindParam(':id', $productId);
        $query->execute();
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

?>