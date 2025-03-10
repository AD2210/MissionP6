<?php
require_once 'views/View.php';
require_once 'src/models/BookManager.php';
require_once 'src\models\UserFixture.php';
require_once 'src\models\MessageFixture.php';

/**
 * Contrôleur Principale qui gère l'acceuil et les methodes communes
 * @todo faire requetes 4 derniers livres
 */

 class MainController{
    public function showHome(): void
    {
        $bookManager = new bookManager();
        $books = $bookManager->getAllbooks();
        $view = new View("Accueil");
        $view->render("home", [
            'books' => $books
        ]);
    }

    public function showAllBooks(): void
    {
        $bookManager = new bookManager();
        $books = $bookManager->getAllBooks();
        $view = new View("Nos Livres à l'échange");
        $view->render("allBooks", [
            'books' => $books
        ]);
    }

    public function showOneBook(): void
    {
        $bookManager = new bookManager();
        $book = $bookManager->getOneBookById(1);
        $view = new View("Nos Livres à l'échange");
        $view->render("allBooks", [
            'book' => $book
        ]);
    }

    public function GeretateUsers() : void {
        $userFixture = new UserFixture;
        $userFixture->createSomeUsers(10);
    }

    public function GeretateMessages() : void {
        $userFixture = new MessageFixture;
        $userFixture->createSomeMessages(100);
    }
 }