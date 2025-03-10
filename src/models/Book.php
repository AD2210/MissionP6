<?php
/**
 * Entité book, défini par les champs:
 * id : identifiant unique du livre
 * title : Titre du livre
 * author : auteur du livre
 * comment : avis sur le livre
 * available : disponibilité du livre Vrai / Faux
 * id_member : id du proriétaire du livre
 * picture : lien vers l'image du livre
 */
#[\AllowDynamicProperties]
class Book
{
    private int $id;
    private string $title;
    private string $author;
    private string $comment;
    private bool $available;
    private int $id_member; //@Todo problème de liaison avec la table lorsque je respect le Camelcase
    private string $picture;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    public function getAvailable(): bool
    {
        return $this->available;
    }

    public function setAvailable(bool $available): void
    {
        $this->available = $available;
    }

    public function getIdMember(): int
    {
        return $this->id_member;
    }

    public function setIdMember(int $idMember): void
    {
        $this->id_member = $idMember;
    }
    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): void
    {
        $this->picture = $picture;
    }
}