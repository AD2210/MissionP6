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

    /**
     *  Affichage du formulaire d'edition d'un livre
     * Données d'entrées :
     * - le livre selectionné : Book
     * @return void
     */
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

    /**
     * Mise à jour des informaitons d'un livre
     * @return void
     */
    public function updateBook():void {
        
        // On vérifie que l'utilisateur est connecté, si non on le renvoie vers la page login
        UserController::checkIfUserIsConnected();

        // On récupère les données du formulaire et de la session.
        $id = Service::request("id");
        $title = Service::request("title");
        $author = Service::request("author");
        $comment = Service::request("comment");
        $available = Service::request("availability");
        
        // On créer l'instance avec les nouvelles datas
        $book = new Book;
        $book->setId($id);
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setComment($comment);
        $book->setAvailable($available);

        // On fait la mise à jour
        $bookManager = new BookManager;
        $bookManager->updateBook($book);

        // On redirige vers la page du membre.
        Service::redirect("privatePage");
    }

    /**
     * Methode pour supprimer un livre de la base de donnée
     * @return void
     */
    public function deleteBook(): void
    {
        // On vérifie si l'utilisateur est loggé et on récupère l'id du livre à supprimer
        UserController::checkIfUserIsConnected();
        $id=Service::request('id');
                
        //On supprime le livre de la base
        $bookManager = new bookManager;
        $bookManager->deleteBook($id);

        // On redirige vers la page du membre.
        Service::redirect("privatePage");
    }
}