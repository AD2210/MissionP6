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
        $pdo->prepare($sql);
        $this->$pdo->execute([
            'pseudo' => $user->getPseudo(),
            'avatar' => $user->getAvatar(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);
    }

    public function getLastIdUser() : int {
        //Requête pour sortir tous les id des users
        $sql = 'SELECT id from user';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $result->fetchAll();

        return count($result);
    }
}