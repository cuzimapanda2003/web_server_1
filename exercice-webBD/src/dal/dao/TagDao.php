<?php

/**
 * Classe concrète pour le DAO de la table tag en BD. 
 * 
 * Elle permet les opérations CRUDL pour cette table.
 */
class TagDao extends BaseDao
{
    function __construct(ConnexionBd $connexionBd)
    {
        parent::__construct($connexionBd);
    }

    public function selectAll(): array
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM tag ORDER BY nom ASC");
        $requete->execute();

        $tags = array();
        while ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $tag = new Tag($enregistrement['nom'], $enregistrement['id']);
            $tags[] = $tag;
        }

        return $tags;
    }

    public function select(int $id): ?Tag
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT * FROM tag WHERE id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        $tag = null;
        if ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $tag = new Tag($enregistrement['nom'], $enregistrement['id']);
        }

        return $tag;
    }

    public function selectParIds(array $ids): array
    {
        // Si la liste est vide, on retourne une liste vide
        if (empty($ids)) return [];

        // Protection : on garde seulement des entiers uniques
        $ids = array_values(array_unique(array_map('intval', $ids)));

        // Préparation des placeholders pour la requête SQL (autre façon par marqueur positionnels : '?')
        // Ça va donné une chaîne du genre "?, ?, ?, ?" selon le nombre d'ids
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $connexion = $this->getConnexion();

        // La requête ressemblera par exemple à "SELECT * FROM tag WHERE id IN (?, ?, ?, ?)"
        $requete = $connexion->prepare("SELECT * FROM tag WHERE id IN ($placeholders) ORDER BY nom ASC");
        
        // Exécution de la requête avec les ids en paramètres (le binding se fait ici automatiquement)
        // PDO associe automatiquement chaque valeurs du tableau $ids au ? correspondant dans la requête
        $requete->execute($ids);

        $tags = [];
        while ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $tags[] = new Tag($enregistrement['nom'], $enregistrement['id']);
        }

        return $tags;
    }

    public function insert(Tag $tag): void
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("INSERT INTO tag(nom) VALUES(:nom)");
        $requete->bindValue(":nom", $tag->getNom(), PDO::PARAM_STR);
        $requete->execute();

        $id = (int) $connexion->lastInsertId();

        $tag->setId($id);
    }

    public function update(Tag $tag): int
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("UPDATE tag SET nom = :nom WHERE id = :id");
        $requete->bindValue(":nom", $tag->getNom(), PDO::PARAM_STR);
        $requete->bindValue(":id", $tag->getId(), PDO::PARAM_INT);
        $requete->execute();

        return $requete->rowCount();
    }

    public function delete(int $id): int
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("DELETE FROM tag WHERE id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        return $requete->rowCount();
    }
}
