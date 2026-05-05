<?php

class Article
{
    private int $id;
    private string $titre;
    private string $texte;
    private int $auteurId;
    private ?Utilisateur $auteur;
    private bool $publie;
    private ?DateTime $dateCreation;
    private ?DateTime $dateModification;
    private array $tags;
    private array $commentaires;


    public function __construct(
        string $titre,
        string $texte,
        int $auteurId,
        bool $publie,
        ?DateTime $dateCreation = null,
        ?DateTime $dateModification = null,
        int $id = 0
    )
    {
        $this->setId($id);
        $this->setTitre($titre);
        $this->setTexte($texte);
        $this->setAuteurId($auteurId);
        $this->setPublie($publie);
        $this->setDateCreation($dateCreation);
        $this->setDateModification($dateModification);
        $this->tags = array();
        $this->commentaires = array();
        $this->auteur = null;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getTitre(): string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $titre = trim($titre);
        if (empty($titre) || mb_strlen($titre, 'UTF-8') > 255)
            throw new InvalidArgumentException("Le titre '$titre' doit être entre 1 et 255 caractères.");
        $this->titre = $titre;
        return $this;
    }

    public function getTexte(): string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $texte = trim($texte);
        if (empty($texte) || mb_strlen($texte, 'UTF-8') > 65535)
            throw new InvalidArgumentException("Le texte '$texte' doit être entre 1 et 65535 caractères.");
        $this->texte = $texte;
        return $this;
    }

    public function isPublie(): bool
    {
        return $this->publie;
    }

    public function setPublie(bool $publie): self
    {
        $this->publie = $publie;
        return $this;
    }

    public function getAuteurId(): int
    {
        return $this->auteurId;
    }

    public function setAuteurId(int $auteurId): self
    {
        $this->auteurId = $auteurId;
        return $this;
    }

    public function getAuteur(): ?Utilisateur
    {
        return $this->auteur;
    }

    public function setAuteur(?Utilisateur $auteur): self
    {
        $this->auteur = $auteur;
        return $this;
    }

    public function getDateCreation(): ?DateTime
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?DateTime $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getDateModification(): ?DateTime
    {
        return $this->dateModification;
    }

    public function setDateModification(?DateTime $dateModification): self
    {
        $this->dateModification = $dateModification;
        return $this;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;
        return $this;
    }

    public function getCommentaires(): array
    {
        return $this->commentaires;
    }

    public function setCommentaires(array $commentaires): self
    {
        $this->commentaires = $commentaires;
        return $this;
    }

    public function ajouterTag(Tag $tag)
    {
        $this->tags[] = $tag;
    }

    public function ajouterCommentaire(Commentaire $commentaire)
    {
        $this->commentaires[] = $commentaire;
    }
}
