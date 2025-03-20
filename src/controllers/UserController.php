<?php
/**
 * Contrôleur de la partie user, gère les vues public et privée des fiches membres. ainsi que toutes les methodes d'authentification
 */

class UserController
{
    /**
     * Affichage de la page membre connecté, espace privé necessitant d'être logué
     * Données d'entrées :
     * - User connecté : User
     * - Liste de tous les livres du User connecté : Array(Book)
     * @return void
     */
    public function showPrivatePage(): void
    {   
        $this->checkIfUserIsConnected();

        $userManager = new UserManager;
        $user = $userManager->getOneUserById(33);
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooksByIdMember($user->getId());

        $view = new View("Page personelle de " .$user->getPseudo());
        $view->render("privatePage", [
            'user' => $user,
            'books' => $books
        ]);
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    private function checkIfUserIsConnected(): void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Service::redirect("loginPage");
        }
    }

    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayLoginPage(): void
    {
        $view = new View("Connexion");
        $view->render("loginPage");
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire.
        $email = Service::request("email");
        $password = Service::request("password");

        // On vérifie que les données sont valides. 
        // @todo a mettre dans l'entité
        if (empty($email) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByEmail($email);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            echo 'planté 3';
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;

        // On redirige vers la page privée du membre.
        Service::redirect("privatePage");
    }

    /**
     * Déconnexion de l'utilisateur.
     * @return void
     */
    public function disconnectUser(): void
    {
        // On déconnecte l'utilisateur.
        unset($_SESSION['user']);

        // On redirige vers la page d'accueil.
        Service::redirect("home");
    }
}