<?php

require_once 'src/models/UserManager.php';
require_once 'src/models/MessageManager.php';

/**
 * Contrôleur qui gère la messagerie
 */

 class MessageController{

    /**
     * Affichage de la messagerie, necessite d'être logué
     * Données d'entrées :
     * - User connecté : User
     * - Tableau des derniers messages recu par correspondant aggrégé avec les données users : Array
     * - le correspondant permettant d'afficher les message d'un fil de discussion : User
     * - le fil de discussion : Array(Message)
     * @return void
     */
    public function showMessaging(): void
    {   
        // On vérifie que l'utilisateur est connecté, si non on le renvoie vers la page login
        UserController::checkIfUserIsConnected();

        // On récupère les infos de l'utilisateur connecté
        $userManager = new UserManager;
        $user = $userManager->getOneUserById($_SESSION['idUser']);
        
        //On récupère les derniers messages pour afficher une sorte d'inbox avec les données utilisateurs
        $messageManager = new MessageManager;
        $LastMessagesWithUsers = $messageManager-> getAllUsersAndMessageByLastMessage($user->getId());
        
        //On choisi quel fil de discussion doit s'afficher, par défault le dernier reçu
        $corresponding = Service::request('corresponding',
            array_column($LastMessagesWithUsers, 'idSender')[0]);
            var_dump($corresponding);
        $correspondingUser = $userManager->getOneUserById($corresponding);

        //Update status read

        //On récupère les message du fil correspondant
        $messageManager = new MessageManager;
        $messageThread = $messageManager->getAllMessagesByIdReceiverAndIdSender($user->getId(),$correspondingUser->getId());

        $view = new View("Page publique de " .$user->getPseudo());
        $view->render("messaging", [
            'user' => $user,
            'LastMessagesWithUsers' => $LastMessagesWithUsers,
            'messageThread' => $messageThread,
            'correspondingUser' => $correspondingUser
        ]);
    }
 }