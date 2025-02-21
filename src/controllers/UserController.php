<?php
/**
 * Contrôleur de la partie user, gère les vues public et privée des fiches membres.
 */

class UserController
{

    /**
     * Affiche la page public d'un membre.
     * @return void
     */
    public function showPublicPage(): void
    {
        // On récupère les livres et les informations du membre.
        $userManager = new UserManager();
        $user = $userManager->getUserById();
        $bookManager = new BookManager();
        $books = $bookManager->getAllBooksbByMemberId();

        // On affiche la page public du membre'.
        $view = new View("Profil public");
        $view->render("public_page", [
            'livres' => $books,
            'user' => $user
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
            Utils::redirect("connectionForm");
        }
    }

    /**
     * Affichage du formulaire de connexion.
     * @return void
     */
    public function displayConnectionForm(): void
    {
        $view = new View("Connexion");
        $view->render("connectionForm");
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire.
        $login = Utils::request("login");
        $password = Utils::request("password");

        // On vérifie que les données sont valides.
        if (empty($login) || empty($password)) {
            throw new Exception("Tous les champs sont obligatoires. 1");
        }

        // On vérifie que l'utilisateur existe.
        $userManager = new UserManager();
        $user = $userManager->getUserByLogin($login);
        if (!$user) {
            throw new Exception("L'utilisateur demandé n'existe pas.");
        }

        // On vérifie que le mot de passe est correct.
        if (!password_verify($password, $user->getPassword())) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page d'administration.
        Utils::redirect("private_page");
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
        Utils::redirect("home");
    }
}