<?php
require_once 'views/View.php';
require_once 'src/models/BookManager.php';

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
 }