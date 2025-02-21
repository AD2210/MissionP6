<?php

/**
 * Contrôleur Principale qui gère l'acceuil et les methodes communes
 */

 class MainController{
    public function showHome(): void
    {
        $bookManager = new bookManager();
        $books = $bookManager->getAllbooks();

        $view = new View("Accueil");
        $view->render("home", ['articles' => $books]);
    }
 }