<?php
namespace App\Models;
use App\Utils\DataBase;
use \PDO;

class UserModel {
    private $id;
    private $name;
    private $email;
    private $firstName;
    private $address;
    private $password;
    private $role;

    // méthode pour enregistrer un utilisateur en base de données
    public function registerUser(): bool
    {
        // Connexion PDO
        $pdo = DataBase::connectPDO();

        // Requête SQL avec liaison de paramètres pour éviter les injections SQL
        $sql = "INSERT INTO `user`(`name`, `firstName`, `email`, `address`, `password`, `role`) VALUES (:name, :firstName, :email, :address, :password, :role)";
        $pdoStatement = $pdo->prepare($sql);

        $params = [
            ':name' => $this->name,
            ':firstName' => $this->firstName,
            ':email' => $this->email,
            ':address' => $this->address,
            ':password' => $this->password,
            ':role' => $this->role
        ];

        // Exécution de la requête
        $queryStatus = $pdoStatement->execute($params);

        // On retourne le statut
        return $queryStatus;
    }
    
     public function checkEmail(): bool
    {
        // connexion pdo
        $pdo = DataBase::connectPDO();

        // création requête avec liaison de param pour éviter les injections sq
        $sql = "SELECT * FROM `user` WHERE `email` = :email";
        $query = $pdo->prepare($sql);
        $query->bindParam(':email', $this->email);
        $query->execute();
        
        $isMail = $query->fetchColumn();

        // donc l'instruction $isMail > 0 donnera true s'il y'a déjà l'email présent
        return $isMail > 0;
    }

//methode permettant de récupéré l'email et le mot  depasse de l'utilisateur 
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
        $pdoStatement->execute([':email' => $email]);
    
        $result = $pdoStatement->fetchObject('App\Models\UserModel');

        // si l'email ne correspond pas, ça va renvoyer false et on va rentrer dans la condition (car différent de true)        
        if(!$result){
            
            // on donne à result null car notre méthode doit renvoyer soit UserModel soit null
            $result = null;
        }
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