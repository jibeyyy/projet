<?php

namespace App\Models;
use App\Utils\DataBase;
use \PDO;

class ContactModel
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
    public function insertMessage(): bool
    {
        $pdo = DataBase::connectPDO();
        $sql = "INSERT INTO `message`(`lastName`, `FirstName`, `email`, `msg`) VALUES (:lastName, :firstName, :email, :msg)";
        
        $params = [
            'lastName' => $this->lastName,
            'firstName' => $this->firstName,
            'email' => $this->email,
            'msg' => $this->msg,
            
        ];
        $query = $pdo->prepare($sql);
        $queryStatus = $query->execute($params);
        return $queryStatus;
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