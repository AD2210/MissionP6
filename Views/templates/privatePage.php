<?php
/**
 * La PrivatePage affiche les vues HereDoc généré dans le templateMemberpage ainsi que les vue spécifique à cette page
 * @todo refacto avec le form Login
 */
require_once 'templateMemberPage.php';

//Variable HereDoc spécifique page privée
$email = $user->getEmail();
$password = $user->getPassword();

$personalInformations = <<<HTML
            <div class="memberPageInformationMember privatePageTopContainer loginForm">
                <form action="index.php?action=updateUser" method="POST">
                    <p>Vos informations personnelles</p>
                    <div class="formField">
                        <label for="email">Adresse email</label>
                        <input type="email" name="email" id="email" value="$email">
                    </div>
                    <div class="formField">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password" value="$password">
                    </div>
                    <div class="formField">
                        <label for="pseudo">Pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" value="$pseudo">
                    </div>
                    <div class="formField">
                        <button type="submit">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
HTML;

echo $personalContent;
echo $personalInformations;
echo $headerTable;
echo $booksTable;