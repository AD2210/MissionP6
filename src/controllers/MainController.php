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