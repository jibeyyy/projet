<?php

namespace App\Models;
use App\Utils\DataBase;
use \PDO;

class BookModel
{
    private $id;
    private $lastName;
    private $firstName;
    private $email;
    private $msg;

    
        public function getMessages(){
    $pdo = DataBase::connectPDO();
    
    $sql = "SELECT * FROM message";

        $query = $pdo->prepare($sql);
        $query->execute();
        $messages = $query->fetchAll(PDO::FETCH_CLASS,'App\Models\ContactModel');
        return $messages;
        
    }
     public function getId(): int
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail($email)
{
    $this->email = $email;
}

    public function getMsg(): string
    {
        return $this->msg;
    }

    public function setMsg(string $msg)
    {
        $this->msg = $msg;
    }
}