<?php
/**
* Fichier a placer en .gitignore car il contient les données de connexion à la BDD
*/
  
    // En fonction des routes utilisées, il est possible d'avoir besoin de la session ; on la démarre dans tous les cas. 
    session_start();

    // Ici on met les constantes utiles, 
    // les données de connexions à la bdd
    // et tout ce qui sert à configurer. 

    define('TEMPLATE_VIEW_PATH', './views/templates/'); // Le chemin vers les templates de vues.
    define('MAIN_VIEW_PATH', TEMPLATE_VIEW_PATH . 'main.php'); // Le chemin vers le template principal.

    define('DB_HOST', '');
    define('DB_NAME', 'tom_troc');
    define('DB_USER', '');
    define('DB_PASS', '');



