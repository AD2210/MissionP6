<?php

require_once 'config/config.php';
require_once 'src/controllers/MainController.php';
// a paramétré à la fin : require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
//$action = Utils::request('action', 'home');
//$action = 'home';
//$action = 'allBooks';
//$action = 'oneBook';
//$action = 'addUsers';
//$action = 'addMessages';
//$action = 'addBooks';
//$action = 'loginPage';
$action = 'privatePage';
$action = 'publicPage';

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages accessibles à tous.
        case 'home':
            $articleController = new MainController();
            $articleController->showHome();
            break;

        case 'allBooks':
            $articleController = new MainController();
            $articleController->showAllBooks();
            break;
        
        case 'oneBook':
            $articleController = new MainController();
            $articleController->showOneBook();
            break;

        case 'addUsers':
            $articleController = new MainController();
            $articleController->geretateUsers();
            break;

        case 'addMessages':
            $articleController = new MainController();
            $articleController->geretateMessages();
            break;

        case 'addBooks':
            $articleController = new MainController();
            $articleController->geretateBooks();
            break;

        case 'loginPage':
            $articleController = new MainController();
            $articleController->showLogin();
            break;

        case 'privatePage':
            $articleController = new MainController();
            $articleController->showPrivatePage();
            break;

        case 'publicPage':
            $articleController = new MainController();
            $articleController->showPublicPage();
            break;
    
        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('error', ['errorMessage' => $e->getMessage()]);
}
