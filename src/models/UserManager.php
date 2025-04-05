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
     * Requête renvoyant un utilisateur grâce a son email, utiliser pour autologue après l'inscription
     * @param string $email
     * @return User|bool
     */
    public function getUserByEmail(string $email): User|bool
    {
        $sql = "SELECT * FROM user WHERE email = :email";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'email' => $email
        ]);
        $result->setFetchMode(PDO::FETCH_CLASS, User::class);
        return $result->fetch();
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
     * Requête permettant d'ajouter en BDD un nouvel utilisateur, vérifie si l'avatar est défini si non renvoie un avatar par défault
     * @param User $user
     * @return void
     */
    public function addNewUser(User $user): void
    {
        $pdo = DBManager::getInstance()->getPDO();

        //Si pas d'avatar défini (cas normal) renvoie un avatar par défaut (paramétré dans la bdd)
        if ($user->getAvatar() == null) {
            $sql = "INSERT INTO user (pseudo, avatar, email, password, registerDate) 
            VALUES (:pseudo, DEFAULT, :email, :password, now())";

            $result = $pdo->prepare($sql);
            $result->execute([
                'pseudo' => $user->getPseudo(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
        } else {
            $sql = "INSERT INTO user (pseudo, avatar, email, password, registerDate) 
                VALUES (:pseudo, :avatar, :email, :password, now())";

            $result = $pdo->prepare($sql);
            $result->execute([
                'pseudo' => $user->getPseudo(),
                'avatar' => $user->getAvatar(),
                'email' => $user->getEmail(),
                'password' => $user->getPassword()
            ]);
        }
    }

    /**
     * Requête permettant de renvoyer le dernier id utilisateur généré
     * @return int
     * @annotation Methode utilisé pour le fonctionnement des fixtures
     */
    public function getLastUserId(): int
    {
        //Requête pour sortir le dernier ID utilisé
        $sql = 'SELECT MAX(id) FROM user';
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->query($sql);
        $array = $result->fetch();
        // Si la requête renvoie null = BDD vide ou false, on renvoie 0
        if (is_null($array['MAX(id)']) || !$array) {
            return 0;
        }
        return $array['MAX(id)'];
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

    /**
     * Requête permettant de mettre à jour le pseudo, l'email ou le mot de passe d'un profil membre
     * @param User $user
     * @return void
     */
    public function updateUser(User $user): void
    {
        $sql = "UPDATE user SET pseudo = :pseudo, email = :email, password = :password WHERE id= :id";
        $pdo = DBManager::getInstance()->getPDO();
        $result = $pdo->prepare($sql);
        $result->execute([
            'id' => $user->getId(),
            'pseudo' => $user->getPseudo(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword()
        ]);
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
    static public function calculationSeniority(DateTime $dateTime): string
    {
        $now = new DateTime('now');
        $dateDiff = date_diff($dateTime, $now);
        $array = json_decode(json_encode($dateDiff), true); // on convertie l'objet en tableau associatif

        if ($array['y'] > 1) {
            return $dateDiff->format('Membre depuis %y ans');
        } elseif ($array['y'] > 0) {
            return $dateDiff->format('Membre depuis %y an');
        } elseif ($array['m'] > 0) {
            return $dateDiff->format('Membre depuis %m mois');
        } elseif ($array['d'] > 0) {
            return $dateDiff->format('Membre depuis %d jours');
        } else {
            return 'Nouveau membre';
        }
    }
}