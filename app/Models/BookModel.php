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
    private $stock;
    private $user_id;


    public static function getAllBooks() {
    $pdo = DataBase::connectPDO();

    $sql = 'SELECT * FROM Book';
    $pdoStatement = $pdo->prepare($sql);
    $pdoStatement->execute();

    $bookData = $pdoStatement->fetchAll(PDO::FETCH_CLASS,'App\Models\BookModel');

    return $bookData;
}
    public static function getBookById(int $id): ?BookModel
    {
        
        // connection pdo
        $pdo = DataBase::connectPDO();
       
        // impératif, :id permet d'éviter les injections SQL
        $query = $pdo->prepare('SELECT * FROM Book WHERE id=:id');
        // Comme il n'y a qu'un seul param, pas besoin de faire un tableau, on peut utiliser bindParam
        $query->bindParam(':id', $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\BookModel');
        // fetch et non fetchAll car on récupère une seule entrée
        $book = $query->fetch();       
       
        return $book;
    }

    public function insertBook(): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = "INSERT INTO `Book`(`img`, `name`, `resume`, `price`, `stock`) VALUES (:img, :name, :resume, :price, :stock)";
        
        $params = [
            'name' => $this->name,
            'img' => $this->img,
            'resume' => $this->resume,
            'price' => $this->price,
            'stock' => $this->stock
        ];
        $query = $pdo->prepare($sql);
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

   public function updateBook(): bool
{
    $pdo = DataBase::connectPDO();
    $user_id = $_SESSION['user_id'];
    $sql = "UPDATE `Book` SET `name` = :name, `img` = :img, `resume` = :resume, `price` = :price WHERE `id` = :id";
    
    $params = [
        'id' => $this->id, // Assurez-vous d'avoir l'ID du livre que vous souhaitez mettre à jour
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

    public function setPrice(int $price)
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

    public function setResume(string $resume)
    {
        $this->resume = $resume;
    }

    public function getStock(): int
    {
        return $this->stock;
    }

    public function setStock(int $stock)
    {
        $this->stock = $stock;
    }
    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }
}
?>
