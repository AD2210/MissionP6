<?php
require_once 'views/View.php';
require_once 'src/models/BookManager.php';
require_once 'src\models\UserFixture.php';
require_once 'src\models\MessageFixture.php';
require_once 'src\models\BookFixture.php';

/**
 * Contrôleur Principale qui gère l'acceuil et les methodes communes
 * @todo faire requetes 4 derniers livres
 */

 class MainController{
    public function showHome(): void
    {
        $bookManager = new bookManager();
        $books = $bookManager->getFourLastBooks();
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
        $bookManager = new bookManager;
        $userManager = new UserManager;
        $book = $bookManager->getOneBookById(1);
        $user = $userManager->getOneUserById($book->getIdMember());
        $view = new View("Le livre");
        $view->render("oneBook", [
            'book' => $book,
            'user' => $user
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

    public function GeretateBooks() : void {
        $userFixture = new BookFixture;
        $userFixture->createSomeBooks(100);
    }
 }