<?php

namespace App\Models;
use App\Utils\DataBase;
use \PDO;

class BookModel
{
    private $id;
    private $name;
    private $img;
    private $resume;
    private $price;
    private $ordre_ID;


    public static function getAllBooks() {
    $pdo = DataBase::connectPDO();

    $sql = 'SELECT * FROM Book';
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute();

    $bookData = $pdoStatement->fetchAll(PDO::FETCH_CLASS,'App\Models\BookModel');

    return $bookData;
}
    public static function getBookById(int $id)
{
    // Connexion PDO
    $pdo = DataBase::connectPDO();
    
    $sql = 'SELECT * FROM Book WHERE id = :id';
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute([':id' => $id]);
 
    $bookData = $pdoStatement->fetch(PDO::FETCH_ASSOC);
    
    
    $book = new BookModel();
    $book->setId($bookData['id']);
    $book->setImg($boodata['img']);
    $book->setName($bookData['name']);
    $book->setResume($bookData['resume']);
    $book->setPrice($bookData['price']);
    
    return $book;
}

    public function insertBook(): bool
    {
        $pdo = DataBase::connectPDO();
        $ordre_ID = $_SESSION['user_id']->getId();
        $sql = "INSERT INTO `Book`(`img`, `name`, `resume`, `price`, `ordre_ID`) VALUES (:img, :name, :resume, :price, :ordre_ID)";
        
        $params = [
            'name' => $this->name,
            'img' => $this->img,
            'resume' => $this->resume,
            'price' => $this->price,
            'ordre_ID' => $this->ordre_ID
        ];
        $query = $pdo->prepare($sql);
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public function updateBook(): bool
    {
        $pdo = DataBase::connectPDO();
        $ordre_ID = $_SESSION['user_id']->getId();
        $sql = "UPDATE `Book` SET `name` = :name, `img` = :img, `resume` = :resume, `price` = :price, `ordre_ID` = :ordre_ID WHERE `id` = :id";
        // associations des bonnes valeurs
        $params = [
            'id' => $this->id,
            'name' => $this->name,
            'img' => $this->img,
            'resume' => $this->resume,
            'price' => $this->price,
            
        ];
        $query = $pdo->prepare($sql);
 
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public static function deleteBook(int $bookId): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = 'DELETE FROM `Book` WHERE id = :id';
        $query = $pdo->prepare($sql);
        $query->bindParam('id', $bookId, PDO::PARAM_INT);
        $queryStatus = $query->execute();
        return $queryStatus;
    }
    public function getStockByName($name) {
    $pdo = DataBase::connectPDO();
    $sql = 'SELECT stock FROM Book WHERE name = :name';
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute([':name' => $name]);
    $stock = $pdoStatement->fetchColumn();
    return $stock;
}

public function updateStockByName($name, $newStock) {
    $pdo = DataBase::connectPDO();
    $sql = 'UPDATE Book SET stock = :newStock WHERE name = :name';
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute([':newStock' => $newStock, ':name' => $name]);
}

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getImg(): string
    {
        return $this->img;
    }

    public function setImg($img)
    {
        $this->img = $img;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): int
    {
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
{
    $this->name = $name;
}

    public function getResume(): string
    {
        return $this->resume;
    }

    public function setResume(string $resume): string
    {
        $this->resume = $resume;
    }

    public function getOrdreId(): int
    {
        return $this->ordre_ID;
    }

    public function setOrdreId(int $ordre_ID): string
    {
        $this->ordre_ID = $ordre_ID;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): int
    {
        $this->quantity = $quantity;
    }
}
    


?>
