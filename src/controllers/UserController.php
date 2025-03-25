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
        // On vérifie que l'utilisateur est connecté, si non on le renvoie vers la page login
        $this->checkIfUserIsConnected();
        $privatePage = true;

        $userManager = new UserManager;
        $user = $userManager->getOneUserById($_SESSION['idUser']);
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooksByIdMember($user->getId());

        $view = new View("Page personelle de " .$user->getPseudo());
        $view->render("privatePage", [
            'user' => $user,
            'books' => $books,
            'privatePage' => $privatePage
        ]);
    }

    /**
     * Affichage de la page membre public
     * Données d'entrées :
     * - User selectionné : User
     * - Liste de tous les livres du User selectionné : Array(Book)
     * @return void
     */
    public function showPublicPage(): void
    {   
        $privatePage = false;
        //récuperer le Get avec id member
        $userManager = new UserManager;
        $user = $userManager->getOneUserById(33);
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooksByIdMember($user->getId());

        $view = new View("Page publique de " .$user->getPseudo());
        $view->render("publicPage", [
            'user' => $user,
            'books' => $books,
            'privatePage' => $privatePage
        ]);
    }

    /**
     * Vérifie que l'utilisateur est connecté.
     * @return void
     */
    public static function checkIfUserIsConnected(): void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Service::redirect("loginPage");
        }
    }

    /**
     * Affichage de la page Login/Inscription 
     * Données d'entrées :
     * - Flag connexion/inscription : Bool
     * @return void
     */
    public function showLogin(): void
    {
        $connexion = Service::request('connexion',false);
        $view = new View("Login");
        $view->render("loginPage", [
            'connexion' => $connexion
        ]);
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
            throw new Exception("Le mot de passe est incorrect : $hash");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

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

    /**
     * Mise à jour des informaitons personnelles d'un utilisateur
     * @return void
     * @todo vérifier prk mise a jour de la date
     */
    public function updateUser():void {
        
        // On récupère les données du formulaire et de la session.
        $id = $_SESSION['idUser'];
        $pseudo = Service::request("pseudo");
        $email = Service::request("email");
        $password = Service::request("password");
        
        // On créer l'instance avec les nouvelles datas
        $user = new User;
        $user->setId($id);
        $user->setPseudo($pseudo);
        $user->setEmail($email);
        $user->setPassword($password);

        var_dump($user);

        $userManager = new UserManager;
        $userManager->updateUser($user);

        // On redirige vers la page d'accueil.
        Service::redirect("privatePage");
    }
}