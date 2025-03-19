<?php

/**
 * Classe Service : cette classe ne contient que des méthodes statiques qui peuvent être appelées
 * directement sans avoir besoin d'instancier un objet Service.
 */
class Service
{
    /**
     * Redirige vers une URL.
     * @param string $action : l'action que l'on veut faire (correspond aux actions dans le routeur = index.php).
     * @param array $params : Facultatif, les paramètres de l'action sous la forme ['param1' => 'valeur1', 'param2' => 'valeur2']
     * @return void
     */
    public static function redirect(string $action, array $params = []): void
    {
        $url = "index.php?action=$action";
        foreach ($params as $paramName => $paramValue) {
            $url .= "&$paramName=$paramValue";
        }
        header("Location: $url");
        exit();
    }

    /**
     * Cette méthode retourne le code js a insérer en attribut d'un bouton.
     * pour ouvrir une popup "confirm", et n'effectuer l'action que si l'utilisateur
     * a bien cliqué sur "ok".
     * @param string $message : le message à afficher dans la popup.
     * @return string : le code js à insérer dans le bouton.
     */
    public static function askConfirmation(string $message): string
    {
        return "onclick=\"return confirm('$message');\"";
    }

    /**
     * Cette méthode permet de récupérer une variable de la superglobale $_REQUEST.
     * Si cette variable n'est pas définie, on retourne la valeur null (par défaut)
     * ou celle qui est passée en paramètre si elle existe.
     * @param string $variableName : le nom de la variable à récupérer.
     * @param mixed $defaultValue : la valeur par défaut si la variable n'est pas définie.
     * @return mixed : la valeur de la variable ou la valeur par défaut.
     */
    public static function request(string $variableName, mixed $defaultValue = null): mixed
    {
        return $_REQUEST[$variableName] ?? $defaultValue;
    }

    /**
     * Methode statique permettant de formater une date
     * @param DateTime|string $date
     * @param string $format
     * @annotation Se repporter à la documentation date_format pour les formats acceptés
     * @link https://www.php.net/manual/fr/datetime.format.php
     * @return string
     */
    public static function dateFormater(DateTime|string $date, string $format) : string {
        // on vérifie le format d'entreé de la date, si c'est un string on le converti en objet DateTime
        if(is_string($date)){
            $date = new DateTime($date);
        }
        return date_format($date,$format);
    }

}