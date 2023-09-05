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

    // méthode pour récupérer tous les articles
    public static function getBook(int $limit = 1): array
    {
        $pdo = DataBase::connectPDO();
        if (!empty($limit)) {
            $query = $pdo->prepare('SELECT * FROM Book ORDER BY date DESC LIMIT ' . $limit);
        } else {
            $query = $pdo->prepare('SELECT * FROM Book ORDER BY date DESC');

        }


        $query->execute();
        $book= $query->fetchAll(PDO::FETCH_CLASS, 'App\Models\BookModel.php');
        return $book;
        
    }

    public static function getBookById(int $id): ?BookModel
    {
        // connection pdo
        $pdo = DataBase::connectPDO();
        $query = $pdo->prepare('SELECT * FROM Book WHERE id=:id');
        $query->bindParam(':id', $id);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_CLASS, 'App\Models\BookModel');
        $book = $query->fetch();        
        return $book;
}
    public function insertBook(): bool
    {
        $pdo = DataBase::connectPDO();
        $ordre_ID = $_SESSION['userObject']->getId();
        // requête sql protégée des injections sql 
        $sql = "INSERT INTO `Book`(`img`, `name`, `resume`, `price`, `ordre_ID`) VALUES (:img, :name, :resume, :price, :ordre_ID)";
        
        $params = [
            'name' => $this->name,
            'img' => $this->img,
            'resume' => $this->resume,
            'price' => $this->price,
            'ordre_ID' => $ordre_ID
        ];
        $query = $pdo->prepare($sql);
        $queryStatus = $query->execute($params);
        return $queryStatus;
    }

    public function updateBook(): bool
    {
        $pdo = DataBase::connectPDO();
        $ordre_ID = $_SESSION['userObject']->getId();
        $sql = "UPDATE `Book` SET `name` = :name, `img` = :img, `resume` = :resume, `price` = :price, `ordre_ID` = :ordre_ID WHERE `id` = :id";
        // associations des bonnes valeurs
        $params = [
            'id' => $this->id,
            'name' => $this->name,
            'img' => $this->img,
            'resume' => $this->resume,
            'price' => $this->price,
            'ordre_ID' => $this->ordre_ID
        ];
        $query = $pdo->prepare($sql);
        // execution de la méthode en passant le tableau de params
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

    public function setImg(string $img)
    {
        $this->img = $img;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(string $price): int
    {
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): string
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
}


?>
