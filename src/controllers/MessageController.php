<?php

require_once 'src/models/UserManager.php';
require_once 'src/models/MessageManager.php';

/**
 * Contrôleur qui gère la messagerie
 */

class MessageController
{

    /**
     * Affichage de la messagerie, necessite d'être logué
     * Données envoyées :
     * - User connecté : User
     * - Tableau des derniers messages recu par correspondant aggrégé avec les données users : Array
     * - le correspondant permettant d'afficher les message d'un fil de discussion : User
     * - le fil de discussion : Array(Message)
     * @throws \Exception
     * @return void
     */
    public function showMessaging(): void
    {
        // On vérifie que l'utilisateur est connecté, si non on le renvoie vers la page login
        UserController::checkIfUserIsConnected('messaging');

        // On récupère les infos de l'utilisateur connecté
        $userManager = new UserManager;
        $user = $userManager->getOneUserById($_SESSION['idUser']);

        //On choisi quel fil de discussion doit s'afficher, par défault le dernier fil actif, si aucun fil on renvoie une erreur
        $messageManager = new MessageManager;
        $corresponding = Service::request(
            'corresponding',
            $messageManager->getLastIdSenderByIdReceiverFromLastMessage($user->getId())
        );
        $correspondingUser = $userManager->getOneUserById($corresponding);

        if (!$correspondingUser) {
            throw new Exception("La messagerie est vide, vous devez d'abord envoyer ou recevoir un message pour acceder à cette fonctionnalitée");
        }

        //Lorsque l'on selectionne un fil, on mets à jour le status à Lu
        $messageManager->updateReadflag($corresponding);

        //On récupère les derniers messages pour afficher une inbox avec les données utilisateurs
        $LastMessagesWithUsers = $messageManager->getAllUsersAndMessageByLastMessage($user->getId());

        //On récupère les messages du fil correspondant
        $messageThread = $messageManager->getAllMessagesByIdReceiverAndIdSender(
            $user->getId(),
            $correspondingUser->getId()
        );

        //On génère la vue avec les paramètres requêtés
        $view = new View("Page publique de " . $user->getPseudo());
        $view->render("messaging", [
            'user' => $user,
            'LastMessagesWithUsers' => $LastMessagesWithUsers,
            'messageThread' => $messageThread,
            'correspondingUser' => $correspondingUser
        ]);
    }

    /**
     * Methode qui gère l'envoie d'un nouveau message, necessite d'être logué
     * @throws \Exception
     * @return void
     */
    public function sendNewMessage(): void
    {
        // On vérifie que l'utilisateur est connecté, si non on le renvoie vers la page login
        UserController::checkIfUserIsConnected('messaging');

        // On récupère les données du formulaire.
        $content = Service::request("message");
        $correspondingId = Service::request("correspondingId");

        // On vérifie que les données sont valides. 
        if (empty($content)) {
            throw new Exception("Le message ne doit pas être vide");
        }

        // On créer le nouveau message puis on l'enregistre en BDD
        $messageManager = new MessageManager;
        $message = new Message();
        $message->setIdSender($_SESSION['idUser']);
        $message->setIdReceiver($correspondingId);
        $message->setContent($content);

        $messageManager->addNewMessage($message);

        //On redirige l'utilisateur vers le fil en cours
        Service::redirect('messaging', [
            'corresponding' => $correspondingId
        ]);
    }
}