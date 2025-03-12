<?php
require 'AbstractEntity.php';

/**
 * Entité User, défini par les champs :
 * id : identifiant unique du membre , défini dans class abstraite
 * pseudo : pseudonyme du membre
 * avatar : lien vers image représentant le membre
 * email : email du membre
 * password : mot de passe
 * register_date : date d'inscription
 */

#[\AllowDynamicProperties]
class User extends AbstractEntity
{
    private string $pseudo;
    private ?string $avatar;
    private string $email;
    private string $password;
    private DateTime|string $register_date; // necessite que l'attribut est un format snake_case pour coller avec la bdd

    public function __construct(){
        if (is_string($this->register_date)){
            $this->register_date = new DateTime($this->register_date);
        }
    }

    public function getPseudo(): string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    public function getRegisterDate(): DateTime
    {
        return $this->register_date;
    }

    public function setRegisterDate(DateTime|string $registerDate): void
    {
        if (is_string($this->register_date)){
            $this->register_date = new DateTime($this->register_date);
        }else{
            $this->register_date = $registerDate;
        }
    }
}