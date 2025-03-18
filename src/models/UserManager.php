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
        return $result->fetchAll(PDO::FETCH_CLASS, USER::class);
    }

    public function getAllUsersByArrayIds(array $ids): array
    {
        //on transforme l'array des ids en string de valeur
        $listIds = implode(', ',$ids);
        $sql = "SELECT * FROM user WHERE id IN (:list)";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'list' => $listIds
        ]);
        return $result->fetchAll(PDO::FETCH_CLASS, USER::class);
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
        $sql = "SELECT * FROM user WHERE id = :id";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $result->fetch();
    }

    public function addNewUser(User $user): void //@todo faire les contrôles de saisie dans l'entité
    {
        $sql = "INSERT INTO user (pseudo, avatar, email, password, registerDate) 
            VALUES (:pseudo, :avatar, :email, :password, now())";
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
        $sql = "SELECT id FROM user EXCEPT SELECT id FROM user WHERE id = :id";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'id' => $id
        ]);
        return $result->fetchAll();
    }

    static public function calculationSeniority(DateTime $dateTime):string {
        $now = new DateTime('now');
        $dateDiff = date_diff($dateTime,$now);
        $array = json_decode(json_encode($dateDiff),true); // on convertie l'objet en tableau

        if ($array['y']>0){
            return $dateDiff->format('Membre depuis %y an');
        }elseif($array['m']>0){
            return $dateDiff->format('Membre depuis %m mois');
        }elseif($array['d']>0){
            return $dateDiff->format('Membre depuis %d jours');
        }else{
            return 'Nouveau membre';
        }
    }
}