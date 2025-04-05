<?php
/**
 * Class de création de données fictives dans la base
 */
require_once 'UserManager.php';

class UserFixture
{

    /**
     * Methode pour créer un utilisateur fictif
     * @return void
     */
    function createOneUser(): void
    {
        // On créer une instance de User et de son Manager
        $userManager = new UserManager;
        $user = new User;

        // On génère des datas fictives pour allimenter la bdd durant le developpement
        $user->setPseudo('user' . $userManager->getLastUserId() + 1);
        $user->setAvatar('https://picsum.photos/200?random=' . $userManager->getLastUserId() + 1);
        $user->setEmail($user->getPseudo() . '@fixture.fr');
        $user->setPassword($user->getPseudo());

        //on enregistre en BDD
        $userManager->addNewUser($user);
    }

    /**
     * Methode pour créer en lot des utilisateur fictifs
     * @param int $nb
     * @return void
     */
    function createSomeUsers(int $nb): void
    {
        for ($i = 0; $i < $nb; $i++) {
            $fixture = new UserFixture;
            $fixture->createOneUser();
        }
    }
}