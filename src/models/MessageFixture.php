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
     * appelle nb fois la fonction createOneMessage
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
     * Renvoie un id aléatoire à partir de la liste des ID users, 
     * permet de renvoyé un id aléatoire différent de celui déjà paramétré pour le recepteur du message
     * @param array $array
     * @param mixed $idReceiver
     * @return int
     */
    public function randId(?int $idReceiver = 0): int
    {
        $userManager = new UserManager;
        $array = $userManager->getAllUsersId();

        if (!isset($idReceiver)) {
            return array_rand($array, 1);
        } else {
            return array_rand(array_splice($array, $idReceiver + 1, 1), 1);
        }
    }

}