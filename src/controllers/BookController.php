<?php
/**
 * Contrôleur de la partie book, gère les vues de tous les livre, fiche de détail, formulaire de modification et d'ajout
 */

class BookController
{
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

    public function showBookForm(): void
    {
        UserController::checkIfUserIsConnected();
        $id=Service::request('id');
        
        $bookManager = new bookManager;
        $book = $bookManager->getOneBookById($id);
        $view = new View("Edition du livre");
        $view->render("editBookForm", [
            'book' => $book
        ]);
    }

    public function deleteBook(): void
    {
        UserController::checkIfUserIsConnected();
        $id=Service::request('id');
        
        $bookManager = new bookManager;
        $book = $bookManager->getOneBookById($id);
        
        $view = new View("Edition du livre");
        $view->render("editBook", [
            'book' => $book
        ]);
    }
}