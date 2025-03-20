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
        $bookManager = new BookManager;
        $books = $bookManager->getFourLastBooks();

        $userManager = new UserManager;

        $view = new View("Accueil");
        $view->render("home", [
            'session' => $_SESSION,
            'books' => $books,
            'userManager' => $userManager
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
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooks();

        $userManager = new UserManager;

        $view = new View("Nos Livres à l'échange");
        $view->render("allBooks", [
            'books' => $books,
            'userManager' => $userManager
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
        $connexion = Service::request('connexion',false);
        $view = new View("Login");
        $view->render("loginPage", [
            'connexion' => $connexion
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