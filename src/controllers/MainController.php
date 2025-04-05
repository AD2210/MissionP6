<?php
require_once 'views/View.php';
require_once 'src/models/BookManager.php';
require_once 'src/models/UserFixture.php';
require_once 'src/models/MessageFixture.php';
require_once 'src/models/BookFixture.php';

/**
 * Contrôleur Principale qui gère l'acceuil et les methodes communes
 */

class MainController
{
    /**
     * Affichage de la page d'acceuil
     * Données d'entrées :
     * - 4 derniers livres ajoutés en BDD : Array(Book)
     * @return void
     */
    public function showHome(): void
    {
        //On récupère les derniers livres ajoutés sur la plateforme pour les afficher sur la page d'acceuil
        $bookManager = new BookManager;
        $books = $bookManager->getFourLastBooks();

        //On passe en paramètre un UserManager pour récupèrer les informations utilisateur pour chaque livres affichés
        $userManager = new UserManager;

        //On génère la vue
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
     * On précise ici le nombre de données à créer
     * @return void
     */
    public function geretateUsers(): void
    {
        $userFixture = new UserFixture;
        $userFixture->createSomeUsers(10);
    }

    /**
     * Methode pour généré des messages fictifs
     * On précise ici le nombre de données à créer
     * @return void
     */
    public function geretateMessages(): void
    {
        $userFixture = new MessageFixture;
        $userFixture->createSomeMessages(100);
    }

    /**
     * Methode pour généré des livres fictifs
     * On précise ici le nombre de données à créer
     * @return void
     */
    public function geretateBooks(): void
    {
        $userFixture = new BookFixture;
        $userFixture->createSomeBooks(30);
    }
}