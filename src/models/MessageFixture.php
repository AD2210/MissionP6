<?php
/**
 * Class de création de données fictives dans la base
 */
require_once('MessageManager.php');
require_once('UserManager.php');

class MessageFixture
{

    /**
     * Créer un message fictif en base de donnée pour le developpement
     * @return void
     */
    public function createOnemessage(): void
    {
        $messageManager = new MessageManager;
        $message = new Message;

        // création des datas fictives pour allimenter la bdd durant le developpement
        $message->setIdReceiver($this->randId());
        $message->setIdSender($this->randId($message->getIdReceiver()));
        $message->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec lectus lectus, tincidunt eget mi ac, aliquam semper mi. Nulla nec rhoncus nunc. Sed ultrices vehicula.');
        $message->setReadFlag(random_int(0, 1));

        //on enregistre en BDD
        $messageManager->addNewMessage($message);
    }

    /**
     * Methode pour créer des message en lot
     * @param int $nb
     * @return void
     */
    public function createSomemessages(int $nb): void
    {
        for ($i = 0; $i < $nb; $i++) {
            $fixture = new messageFixture;
            $fixture->createOnemessage();
        }
    }

    /**
     * Renvoie un id aléatoire à partir de la liste des ID users existant, 
     * permet de renvoyer un id aléatoire différent de celui déjà paramétré pour le recepteur du message
     * @param array $array
     * @param mixed $idReceiver
     * @return int
     */
    static public function randId(int $idReceiver = 0): int
    {
        $userManager = new UserManager;
         //On récupère la liste des id utilisateurs et on transforme en array à 1 dimension
         $array = $userManager->getAllUsersId();
        $array = array_column($array, 'id');

        if ($idReceiver == 0) {
            return $array[array_rand($array)]; // Retourne un Id aléatoire
        } else {
            // On récupère la liste des id utilisateurs sans l'id passé en paramètre et on retourne un Id aléatoire
            $array = $userManager->getAllUsersIdExceptOneId($idReceiver);
            $array = array_column($array, 'id');
            return $array[array_rand($array)];
        }
    }

}