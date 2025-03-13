<?php
/**
 * Entité book, défini par les champs:
 * id : identifiant unique du livre
 * title : Titre du livre
 * author : auteur du livre
 * comment : avis sur le livre
 * available : disponibilité du livre Vrai / Faux
 * idMember : id du proriétaire du livre
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
    private int $idMember; //@Todo problème de liaison avec la table lorsque je respect le Camelcase
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

    public function getComment(int $length = -1): string
    {
        if ($length > 0) {
            // Ici, on utilise mb_substr et pas substr pour éviter de couper un caractère en deux (caractère multibyte comme les accents).
            $content = mb_substr($this->comment, 0, $length);
            if (strlen($this->comment) > $length) {
                $content .= "...";
            }
            return $content;
        }
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
        return $this->idMember;
    }

    public function setIdMember(int $idMember): void
    {
        $this->idMember = $idMember;
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