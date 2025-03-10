<?php
require_once 'DBManager.php';
require_once 'User.php';
class UserManager
{
    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM user";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, "user");
    }

    public function getAllUsersId(): array
    {
        $sql = "SELECT id FROM user";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll();
    }

    public function getOneUserById(int $id): User
    {
        $sql = "SELECT * FROM user WHERE id = $id"; // @todo préparer la requette
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $result->setFetchMode(PDO::FETCH_CLASS, "user");
        return $result->fetch();
    }

    public function addNewUser(User $user): void //@todo faire les contrôles de saisie dans l'entité
    {
        $sql = "INSERT INTO user (pseudo, avatar, email, password, register_date) 
            VALUES (:pseudo, :avatar, :email, :password, NOW())";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'pseudo' => $user->getPseudo(),
            'avatar' => $user->getAvatar(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);
    }

    public function getLastUserId() : int {
        //Requête pour sortir le dernier ID utilisé
        $sql = 'SELECT id FROM user';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $array = $result->fetchAll();
        
        return $array[count($array)-1]['id'];
    }

    public function getAllUsersIdExceptOneId(int $id): array
    {
        $sql = "SELECT id FROM user EXCEPT SELECT id FROM user WHERE id = $id";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll();
    }
}