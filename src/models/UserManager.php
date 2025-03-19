<?php

/**
 * Classe permettant les échanges en BDD de l'entité User
 */
require_once 'DBManager.php';
require_once 'User.php';

class UserManager
{
    /**
     * Requête renvoyant tous les utilisateurs présent en BDD
     * @return array
     */
    public function getAllUsers(): array
    {
        $sql = "SELECT * FROM user";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll(PDO::FETCH_CLASS, USER::class);
    }

    /**
     * Requête multi table renvoyant les derniers messages envoyés à un utilisateur donnés
     * agrégé avec les données des utilisateurs ayant envoyé chacun des messages
     * @param int $idReceiver
     * @return array
     */
    public function getAllUsersAndMessageByLastMessage(int $idReceiver): array
    {        
        $sql = 'SELECT avatar, pseudo, sendDate, readFlag, content FROM user INNER JOIN message ON user.id = message.idSender WHERE message.idReceiver = :idReceiver ORDER BY message.id DESC';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
           'idReceiver' => $idReceiver 
        ]);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Requête renvoyant tous les id des utilisateurs présent en BDD
     * @return array
     * @annotation Methode utilisé pour le fonctionnement des fixtures
     */
    public function getAllUsersId(): array
    {
        $sql = "SELECT id FROM user";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        return $result->fetchAll();
    }

    /**
     * Requête renvoyant un utilisateur grâce a son id
     * @param int $id
     * @return User
     */
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

    /**
     * Requête permettant d'ajouter en BDD un nouvel utilisateur
     * @param User $user
     * @return void
     */
    public function addNewUser(User $user): void
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

    /**
     * Requête permettant de renvoyer le dernier id utilisateur généré
     * @return int
     * @annotation Methode utilisé pour le fonctionnement des fixtures
     */
    public function getLastUserId() : int {
        //Requête pour sortir le dernier ID utilisé
        $sql = 'SELECT id FROM user';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $array = $result->fetchAll();
        
        return $array[count($array)-1]['id'];
    }

    /**
     * Requête permettant de renvoyer tous les id utilisateur sauf celui préciser en paramètre
     * @param int $id
     * @return array
     * @annotation Methode utilisé pour le fonctionnement des fixtures
     */
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

    /* ----- Methodes Autres ----- */

    /**
     * Methode permettant de renvoyé l'ancienneté d'un membre
     * on diférencie 5 cas :
     * 1) Nouveau membre (membre depuis < 1jr)
     * 2) Membre depuis x jours (jours compris entre 2 et 30)
     * 3) Membre depuis x mois (mois compris entre 2 et 12)
     * 4) Membre depuis 1 an (an = 1)
     * 5) Membre depuis x ans (ans >1)
     * @param DateTime $dateTime
     * @return string
     */
    static public function calculationSeniority(DateTime $dateTime):string {
        $now = new DateTime('now');
        $dateDiff = date_diff($dateTime,$now);
        $array = json_decode(json_encode($dateDiff),true); // on convertie l'objet en tableau associatif

        if ($array['y']>1){
            return $dateDiff->format('Membre depuis %y ans');
        }elseif($array['y']>0){
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