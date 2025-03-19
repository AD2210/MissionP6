<?php
require_once 'views/View.php';
require_once 'src/models/BookManager.php';
require_once 'src\models\UserFixture.php';
require_once 'src\models\MessageFixture.php';
require_once 'src\models\BookFixture.php';

/**
 * Contrôleur Principale qui gère l'acceuil et les methodes communes
 * @todo redistribuer les methodes dans les contrôleurs dédiés
 */

 class MainController{
    /**
     * Affichage de la page d'acceuil
     * Données d'entrées :
     * - 4 derniers livres ajoutés en BDD : Array(Book)
     * @return void
     */
    public function showHome(): void
    {
        $bookManager = new bookManager();
        $books = $bookManager->getFourLastBooks();
        $view = new View("Accueil");
        $view->render("home", [
            'books' => $books
        ]);
    }

    /**
     * Affichage de la page avec tous les livres à l'échange
     * Données d'entrées :
     * - tous les livres en BDD : Array(Book)
     * @return void
     */
    public function showAllBooks(): void
    {
        $bookManager = new bookManager();
        $books = $bookManager->getAllBooks();
        $view = new View("Nos Livres à l'échange");
        $view->render("allBooks", [
            'books' => $books
        ]);
    }

    /**
     * Affichage de la page de détail d'un livre
     * Données d'entrées :
     * - le livre selectionné : Book
     * - le user propriétaire du livre : User
     * @return void
     */
    public function showOneBook(): void
    {
        $id=Service::request('id');
        
        $bookManager = new bookManager;
        $userManager = new UserManager;
        $book = $bookManager->getOneBookById($id);
        $user = $userManager->getOneUserById($book->getIdMember());
        $view = new View("Le livre");
        $view->render("oneBook", [
            'book' => $book,
            'user' => $user
        ]);
    }

    /**
     * Affichage de la page Login/Inscription 
     * Données d'entrées :
     * - Flag connexion/inscription : Bool
     * @return void
     * @todo contrôle connexion
     */
    public function showLogin(): void
    {
        $connexion = true;
        $view = new View("Login");
        $view->render("loginPage", [
            'connexion' => $connexion
        ]);
    }

    /**
     * Affichage de la page membre connecté, espace privé necessitant d'être logué
     * Données d'entrées :
     * - User connecté : User
     * - Liste de tous les livres du User connecté : Array(Book)
     * @return void
     */
    public function showPrivatePage(): void
    {   //récuperer le Get avec id member et vérifier connexion
        $userManager = new UserManager;
        $user = $userManager->getOneUserById(33);
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooksByIdMember($user->getId());

        $view = new View("Page personelle de " .$user->getPseudo());
        $view->render("privatePage", [
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * Affichage de la page membre public
     * Données d'entrées :
     * - User selectionné : User
     * - Liste de tous les livres du User selectionné : Array(Book)
     * @return void
     */
    public function showPublicPage(): void
    {   //récuperer le Get avec id member
        $userManager = new UserManager;
        $user = $userManager->getOneUserById(33);
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooksByIdMember($user->getId());

        $view = new View("Page publique de " .$user->getPseudo());
        $view->render("publicPage", [
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * Affichage de la messagerie, necessite d'être logué
     * Données d'entrées :
     * - User sconnecté : User
     * - Tableau des derniers messages recu par correspondant aggrégé avec les données users : Array
     * - le correspondant permettant d'afficher les message d'un fil de discussion : User
     * - le fil de discussion : Array(Message)
     * @return void
     */
    public function showMessaging(): void
    {   //récuperer le Get avec id member et vérifier connexion
        $userManager = new UserManager;
        $user = $userManager->getOneUserById(39);
        $correspondingUser = $userManager->getOneUserById(29); //mettre par défault le dernier correspondant si aucun selectionné

        $LastMessagesWithUsers = $userManager-> getAllUsersAndMessageByLastMessage($user->getId());

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

    /* -----Methodes pour fixtures----- */

    /**
     * Methode pour généré des utilisateurs fictifs
     * Données d'entrées :
     * - nombre d'utilisateur à créer : int
     * @return void
     */
    public function geretateUsers() : void {
        $userFixture = new UserFixture;
        $userFixture->createSomeUsers(1);
    }

    /**
     * Methode pour généré des messages fictifs
     * Données d'entrées :
     * - nombre de message à créer : int
     * @return void
     */
    public function geretateMessages() : void {
        $userFixture = new MessageFixture;
        $userFixture->createSomeMessages(10);
    }

    /**
     * Methode pour généré des livres fictifs
     * Données d'entrées :
     * - nombre de livre à créer : int
     * @return void
     */
    public function geretateBooks() : void {
        $userFixture = new BookFixture;
        $userFixture->createSomeBooks(10);
    }
 }