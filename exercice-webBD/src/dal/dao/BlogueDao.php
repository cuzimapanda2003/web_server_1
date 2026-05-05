<?php

class BlogueDao extends BaseDao
{
    private const string PARTIE_REQUETE_SELECT_FROM = "
        SELECT 
            b.id,
            b.nom,
            b.description,
            b.date_creation,
            b.utilisateur_id,
            u.nom_utilisateur,
            u.prenom,
            u.nom AS utilisateur_nom,
            u.courriel,
            u.role_id,
            u.chemin_avatar,
            u.hash,
            r.nom AS role_nom
        FROM blogue AS b
            INNER JOIN utilisateur AS u ON b.utilisateur_id = u.id
            INNER JOIN role AS r ON u.role_id = r.id ";

    public function __construct(ConnexionBd $connexionBd)
    {
        parent::__construct($connexionBd);
    }

    public function selectAll() : array
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare(self::PARTIE_REQUETE_SELECT_FROM);
        $requete->execute();

        $blogues = [];
        while ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $blogue = $this->construireBlogue($enregistrement);
            $blogues[] = $blogue;
        }

        return $blogues;
    }

    public function select(int $id): ?Blogue
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare(self::PARTIE_REQUETE_SELECT_FROM . "WHERE b.id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        $blogue = null;
        if ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $blogue = $this->construireBlogue($enregistrement);
        }

        return $blogue;
    }

    public function selectParBlogueurId(int $blogueurId): ?Blogue
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare(self::PARTIE_REQUETE_SELECT_FROM . "WHERE b.utilisateur_id = :utilisateur_id");
        $requete->bindValue(":utilisateur_id", $blogueurId, PDO::PARAM_INT);
        $requete->execute();

        $blogue = null;
        if ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $blogue = $this->construireBlogue($enregistrement);            
        }

        return $blogue;
    }

    private function construireBlogue($enregistrement): Blogue
    {
        $blogue = new Blogue(
            $enregistrement['nom'],
            $enregistrement['description'],
            $enregistrement['utilisateur_id'],
            new DateTime($enregistrement['date_creation']),
            $enregistrement['id']
        );

        $blogueur = new Utilisateur(
            $enregistrement["nom_utilisateur"],
            $enregistrement["utilisateur_nom"],
            $enregistrement["prenom"],
            $enregistrement["courriel"],
            $enregistrement["role_id"],
            $enregistrement["hash"],
            $enregistrement["chemin_avatar"],
            $enregistrement["utilisateur_id"]
        );
        $blogue->setBlogueur($blogueur);

        $role = new Role(
            $enregistrement['role_nom'],
            $enregistrement['role_id']
        );
        $blogueur->setRole($role);

        return $blogue;
    }
}