<?php
/**
 * Contrôleur de la partie book, gère les vues de tous les livre, fiche de détail, formulaire de modification
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
        //On récupère le contenu de la recherche si existant
        $keyWord = Service::request('bookSearch');
        
        $bookManager = new BookManager;

        if (isset($keyWord)){
            //On récupère tous les livres correspondant à la recherche
            $books = $bookManager->getAllBooksByTitleLikeKeyWord($keyWord);
        }else{
            //si non on récupère tous les livres
            $books = $bookManager->getAllBooks();
        }

        //On passe un userManager en paramètre pour récupérer les informations utilisateur de chaque livre
        $userManager = new UserManager;

        //On génère la vue
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
        //On récupère l'id du livre afficher dans la requête
        $id = Service::request('id');

        // On récupère les informations sur le livre selectionné et son propriétaire
        $bookManager = new bookManager;
        $userManager = new UserManager;
        $book = $bookManager->getOneBookById($id);
        $user = $userManager->getOneUserById($book->getIdMember());

        //On génère la vue
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
        //On vérifie que l'utilisateur est connecté pour acceder à la modification et on récupère l'id du livre à modifier
        UserController::checkIfUserIsConnected('privatePage');
        $id = Service::request('id');

        //On récupère les informations du livre à modifier
        $bookManager = new bookManager;
        $book = $bookManager->getOneBookById($id);

        //On génère la vue
        $view = new View("Edition du livre");
        $view->render("editBookForm", [
            'book' => $book
        ]);
    }

    /**
     * Mise à jour des informaitons d'un livre
     * @return void
     */
    public function updateBook(): void
    {

        // On vérifie que l'utilisateur est connecté, si non on le renvoie vers la page login
        UserController::checkIfUserIsConnected('privatePage');

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
        UserController::checkIfUserIsConnected('privatePage');
        $id = Service::request('id');

        //On supprime le livre de la base
        $bookManager = new bookManager;
        $bookManager->deleteBook($id);

        // On redirige vers la page du membre.
        Service::redirect("privatePage");
    }
}