<?php

namespace App\Models;
use App\Utility\DataBase;

class UserModel {
    private $id;
    private $name;
    private $email;
    private $firstName;
    private $address;
    private $password;
    private $role;

    // méthode pour enregistrer un user en bdd
    public function registerUser(): bool
    {

        // connexion pdo
        $pdo = DataBase::connectPDO();

        // création requête avec liaison de param pour éviter les injections sq
        $sql = "INSERT INTO `user`(`name`,`firstName`,`email`,`address`,`password`,`role`) VALUES (:name,:firstName,:email,:address,:password,:role)";
        // préparation de la requête
        $pdoStatement = $pdo->prepare($sql);
        // liaison des params avec leur valeurs. tableau à passer dans execute
        $params = [
            ':name' => $this->name,
            ':firstName'=> $this->firstName,
            ':email' => $this->email,
            ':address' => $this->address,
            ':password' => $this->password,
            ':role' => 3,
        ];
        // récupération de l'état de la requête (renvoie true ou false)
        $queryStatus = $pdoStatement->execute($params);

        // on retourne le status
        return $queryStatus;
    }

    
    public function checkEmail() {
        
        $pdo = DataBase::connectPDO();

        $sql = "SELECT COUNT(*) FROM `user` WHERE `email` = :email";
       
        $query = $pdo->prepare($sql);
                
        $query->bindParam(':email', $this->email);
        
        $query->execute();
       
        $isMail = $query->fetchColumn();
        return $isMail > 0;
    }

    // récupérer un utilisateur via son email
    public static function getUserByEmail($email): ?UserModel
    {

        // connexion pdo
        $pdo = DataBase::connectPDO();

        // requête SQL
        $sql = '
        SELECT * 
        FROM user
        WHERE email = :email';
        $pdoStatement = $pdo->prepare($sql);
        // on exécute la requête en donnant à PDO la valeur à utiliser pour remplacer ':email'
        $pdoStatement->execute([':email' => $email]);
        // on récupère le résultat sous la forme d'un objet de la classe AppUser
        $result = $pdoStatement->fetchObject('App\Models\UserModel');

        // on renvoie le résultat
        return $result;
    }

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getFirstName(): string 
    {
        return $this->firstNAme;
    }
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    public function getAddress(): string
    {
        return $this->address;
    }
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function setRole(int $role): void
    {
        $this->role = $role;
    }
}