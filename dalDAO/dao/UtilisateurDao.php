<?php

class UtilisateurDao extends BaseDao
{
    private const string PARTIE_REQUETE_SELECT_FROM = "
        SELECT 
            u.id,
            u.nom_utilisateur,
            u.nom,
            u.prenom,
            u.courriel,
            u.role_id,
            u.hash,
            u.chemin_avatar,
            r.nom AS role_nom 
        FROM utilisateur AS u
            INNER JOIN role AS r ON u.role_id = r.id ";

    public function __construct(ConnexionBd $connexionBd)
    {
        parent::__construct($connexionBd);
    }

    public function select(int $id): ?Utilisateur
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare(self::PARTIE_REQUETE_SELECT_FROM . "WHERE u.id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        $utilisateur = null;
        if ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $utilisateur = $this->construireUtilisateur($enregistrement);
        }

        return $utilisateur;
    }

    public function selectParNomUtilisateur(string $nomUtilisateur): ?Utilisateur
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare(self::PARTIE_REQUETE_SELECT_FROM . "WHERE u.nom_utilisateur = :nom_utilisateur");
        $requete->bindValue(":nom_utilisateur", $nomUtilisateur, PDO::PARAM_STR);
        $requete->execute();

        $utilisateur = null;
        if ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $utilisateur = $this->construireUtilisateur($enregistrement);
        }

        return $utilisateur;
    }

    private function construireUtilisateur(array $enregistrement): Utilisateur
    {
        $utilisateur = new Utilisateur(
            $enregistrement['nom_utilisateur'],
            $enregistrement['nom'],
            $enregistrement['prenom'],
            $enregistrement['courriel'],
            $enregistrement['role_id'],
            $enregistrement['hash'],
            $enregistrement['chemin_avatar'],
            $enregistrement['id']
        );

        $role = new Role(
            $enregistrement['role_nom'],
            $enregistrement['role_id']
        );
        $utilisateur->setRole($role);

        return $utilisateur;
    }
}
