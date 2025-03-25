<?php

require_once 'config/config.php';
require_once 'views/View.php';
require_once 'src\models\Service.php';
require_once 'src/controllers/MainController.php';
require_once 'src/controllers/BookController.php';
require_once 'src/controllers/MessageController.php';
require_once 'src/controllers/UserController.php';
// a paramétré à la fin : require_once 'config/autoload.php';

// On récupère l'action demandée par l'utilisateur.
// Si aucune action n'est demandée, on affiche la page d'accueil.
$action = Service::request('action', 'home');

// Try catch global pour gérer les erreurs
try {
    // Pour chaque action, on appelle le bon contrôleur et la bonne méthode.
    switch ($action) {
        // Pages d'affichage.
        case 'home':
            $mainController = new MainController;
            $mainController->showHome();
            break;

        case 'allBooks':
            $bookController = new BookController;
            $bookController->showAllBooks();
            break;
        
        case 'oneBook':
            $bookController = new BookController;
            $bookController->showOneBook();
            break;
        
        case 'editBook':
            $bookController = new BookController;
            $bookController->showBookForm();
            break;

        case 'loginPage':
            $userController = new UserController;
            $userController->showLogin();
            break;

        case 'privatePage':
            $userController = new UserController;
            $userController->showPrivatePage();
            break;

        case 'publicPage':
            $userController = new UserController;
            $userController->showPublicPage();
            break;
    
        case 'messaging':
            $messageController = new MessageController;
            $messageController->showMessaging();
            break;        

        //Methode sans affichage, ex : Connexion

        case 'connectUser':
            $userController = new UserController;
            $userController->connectUser();
            break;

        case 'disconnectUser':
            $userController = new UserController;
            $userController->disconnectUser();
            break;

        case 'newMessage':
            $messageController = new MessageController;
            $messageController->sendNewMessage();
            break;
        
        //Methodes pour fixture, décommenter pour utiliser
        /*  
        case 'addUsers':
            $mainController = new MainController();
            $mainController->geretateUsers();
            break;

        case 'addMessages':
            $mainController = new MainController();
            $mainController->geretateMessages();
            break;

        case 'addBooks':
            $mainController = new MainController();
            $mainController->geretateBooks();
            break;
        */

        default:
            throw new Exception("La page demandée n'existe pas.");
    }
} catch (Exception $e) {
    // En cas d'erreur, on affiche la page d'erreur.
    $errorView = new View('Erreur');
    $errorView->render('error', ['errorMessage' => $e->getMessage()]);
}
