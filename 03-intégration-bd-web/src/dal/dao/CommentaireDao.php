<?php

class CommentaireDao extends BaseDao
{
    public function __construct(ConnexionBd $connexionBd)
    {
        parent::__construct($connexionBd);
    }

    public function selectAllParArticleId(int $articleId): array
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("SELECT 
                                            c.id,
                                            c.texte,
                                            c.date_publication,
                                            c.article_id,
                                            c.utilisateur_id,
                                            u.nom_utilisateur,
                                            u.prenom,
                                            u.nom,
                                            u.courriel,
                                            u.role_id,
                                            u.chemin_avatar,
                                            u.hash,
                                            r.nom AS role_nom
                                        FROM commentaire AS c 
                                            INNER JOIN utilisateur AS u 
                                            ON c.utilisateur_id = u.id 
                                            INNER JOIN role AS r 
                                            ON u.role_id = r.id 
                                        WHERE c.article_id = :article_id 
                                        ORDER BY c.date_publication ASC");
        $requete->bindValue(":article_id", $articleId, PDO::PARAM_INT);
        $requete->execute();

        $commentaires = [];
        while ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $commentaires[] = $this->construireCommentaire($enregistrement);
        }

        return $commentaires;
    }

    public function insert(Commentaire $commentaire): void
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("INSERT INTO commentaire(texte, date_publication, article_id, utilisateur_id) 
                                        VALUES(:texte, NOW(), :article_id, :utilisateur_id)");
        $requete->bindValue(":texte", $commentaire->getTexte(), PDO::PARAM_STR);
        $requete->bindValue(":article_id", $commentaire->getArticleId(), PDO::PARAM_INT);
        $requete->bindValue(":utilisateur_id", $commentaire->getAuteurId(), PDO::PARAM_INT);
        $requete->execute();

        $id = (int) $connexion->lastInsertId();
        $commentaire->setId($id);
    }

    public function delete(int $id): int
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("DELETE FROM commentaire WHERE id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        return $requete->rowCount();
    }

    private function construireCommentaire(array $enregistrement): Commentaire
    {
        $commentaire = new Commentaire(
            $enregistrement['texte'],
            $enregistrement['utilisateur_id'],
            $enregistrement['article_id'],
            new DateTime($enregistrement['date_publication']),
            $enregistrement['id']
        );

        $utilisateur = new Utilisateur(
            $enregistrement['nom_utilisateur'],
            $enregistrement['nom'],
            $enregistrement['prenom'],
            $enregistrement['courriel'],
            $enregistrement['role_id'],
            $enregistrement['hash'],
            $enregistrement['chemin_avatar'],
            $enregistrement['utilisateur_id']
        );
        $commentaire->setAuteur($utilisateur);

        $role = new Role(
            $enregistrement['role_nom'],
            $enregistrement['role_id']
        );
        $utilisateur->setRole($role);

        return $commentaire;
    }
}
