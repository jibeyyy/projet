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

//methode permaettant de récupéré l'email et le mot  depasse de l'utilisateur 
public static function getUserByEmail($email, $password): ?UserModel
{
    // Connexion PDO
    $pdo = DataBase::connectPDO();

    $sql = 'SELECT * FROM user WHERE email = :email';
    $pdoStatement = $pdo->prepare($sql);

    // Exécution de la requête en fournissant la valeur pour ':email'
    $pdoStatement->execute([':email' => $email]);

    // Récupération des données de l'utilisateur
    $userData = $pdoStatement->fetch(PDO::FETCH_ASSOC);

    // Si aucun utilisateur correspondant n'est trouvé ou si le mot de passe est incorrect, retournez null
    if (!$userData || !password_verify($password, $userData['password'])) {
        return null;
    }

    // Création d'un objet UserModel à partir des données récupérées
    $user = new UserModel();
    $user->setId($userData['id']);
    $user->setEmail($userData['email']);
    // Vous n'avez pas besoin de définir le mot de passe ici car il est déjà haché dans la base de données

    return $user;
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