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

        //On récupère les informations de l'utilisateur et les livres dont il est propriétaire
        $userManager = new UserManager;
        $user = $userManager->getOneUserById($_SESSION['idUser']);
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooksByIdMember($user->getId());

        //On génère la vue
        $view = new View("Page personelle de " . $user->getPseudo());
        $view->render("privatePage", [
            'user' => $user,
            'books' => $books,
            'privatePage' => true
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
        // On récupère les données de la requête
        $id = Service::request("id");

        //On récupère les informations de l'utilisateur selectionné et les livres dont il est propriétaire
        $userManager = new UserManager;
        $user = $userManager->getOneUserById($id);
        $bookManager = new BookManager;
        $books = $bookManager->getAllBooksByIdMember($user->getId());

        //On génère la vue
        $view = new View("Page publique de " . $user->getPseudo());
        $view->render("publicPage", [
            'user' => $user,
            'books' => $books,
            'privatePage' => false
        ]);
    }

    /**
     * Vérifie que l'utilisateur est connecté. si non on le rédirige vers la page Login
     * On garde en mémoire la page visité avant la vérification pour le rédirigé avec s'est inscrit ou logué
     * exemple : messagerie
     * @return void
     */
    public static function checkIfUserIsConnected(string $redirectUrl = 'privatePage'): void
    {
        // On vérifie que l'utilisateur est connecté.
        if (!isset($_SESSION['user'])) {
            Service::redirect("loginPage", [
                'redirectUrl' => $redirectUrl
            ]);
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
        //On récupère la mémoire de la page précedente et le flag connexion/inscription
        $redirectUrl = Service::request('redirectUrl', 'privatePage');
        $connexion = Service::request('connexion', false);

        //On génère la vue
        $view = new View("Login");
        $view->render("loginPage", [
            'connexion' => $connexion,
            'redirectUrl' => $redirectUrl
        ]);
    }

    /**
     * Connexion de l'utilisateur.
     * @return void
     */
    public function connectUser(): void
    {
        // On récupère les données du formulaire et de la pag d'origine.
        $email = Service::request("email");
        $password = Service::request("password");
        $redirectUrl = Service::request("redirectUrl");

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
            throw new Exception("Le mot de passe est incorrect");
        }

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page précédente si renseigné ou par defaut la page privée du membre.
        if (isset($redirectUrl)) {
            Service::redirect($redirectUrl);
        }
        Service::redirect('privatePage');
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

    public function createUser(): void
    {
        // On récupère les données du formulaire.
        $pseudo = Service::request("pseudo");
        $email = Service::request("email");
        $password = Service::request("password");

        // On vérifie que les données sont valides. 
        if (empty($email) || empty($password) || empty($pseudo)) {
            throw new Exception("Tous les champs sont obligatoires.");
        }

        //On créer l'utilisateur
        $user = new User;
        $user->setPseudo($pseudo);
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setAvatar('');

        //On l'enregistre en BDD
        $userManager = new UserManager;
        $userManager->addNewUser($user);

        //On récupère l'utilisateur dépuis la BDD (pour avoir l'id autogénéré)
        $user = $userManager->getUserByEmail($email);

        // On connecte l'utilisateur.
        $_SESSION['user'] = $user;
        $_SESSION['idUser'] = $user->getId();

        // On redirige vers la page privée du membre.
        Service::redirect("privatePage");
    }

    /**
     * Mise à jour des informaitons personnelles d'un utilisateur
     * @return void
     */
    public function updateUser(): void
    {

        // On vérifie que l'utilisateur est connecté, si non on le renvoie vers la page login
        $this->checkIfUserIsConnected();

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

        //on enregistre en BDD
        $userManager = new UserManager;
        $userManager->updateUser($user);

        // On redirige vers la page du membre.
        Service::redirect("privatePage");
    }
}