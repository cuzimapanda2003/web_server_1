<?php

class ArticleDao extends BaseDao
{
    private const string PARTIE_REQUETE_SELECT_FROM = "
        SELECT 
            a.id,
            a.titre,
            a.texte,
            a.date_creation,
            a.date_modification,
            a.publie,
            a.utilisateur_id,
            u.nom_utilisateur,
            u.prenom,
            u.nom,
            u.courriel,
            u.role_id,
            u.chemin_avatar,
            u.hash,
            r.nom AS role_nom
        FROM article AS a " .
            "INNER JOIN utilisateur AS u ON a.utilisateur_id = u.id " .
            "INNER JOIN role AS r ON u.role_id = r.id ";

    public function __construct(ConnexionBd $connexionBd)
    {
        parent::__construct($connexionBd);
    }

    public function selectAllParUtilisateurId(int $utilisateurId): array
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare(self::PARTIE_REQUETE_SELECT_FROM . 
                                        "WHERE a.utilisateur_id = :utilisateur_id 
                                        ORDER BY a.date_creation ASC");
        $requete->bindValue(":utilisateur_id", $utilisateurId, PDO::PARAM_INT);
        $requete->execute();

        $articles = [];
        while ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $articles[] = $this->construireArticle($enregistrement);
        }

        return $articles;
    }

    public function select(int $id): ?Article
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare(self::PARTIE_REQUETE_SELECT_FROM . "WHERE a.id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        $article = null;
        if ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $article = $this->construireArticle($enregistrement);
            $this->recupererTags($article, $connexion);
        }

        return $article;
    }

    public function insert(Article $article): void
    {
        try
        {
            $connexion = $this->getConnexion();

            $connexion->beginTransaction();

            $requete = $connexion->prepare("INSERT INTO article(titre, texte, date_creation, date_modification, publie, utilisateur_id) VALUES(:titre, :texte, NOW(), NOW(), :publie, :utilisateur_id)");
            $requete->bindValue(":titre", $article->getTitre(), PDO::PARAM_STR);
            $requete->bindValue(":texte", $article->getTexte(), PDO::PARAM_STR);
            $requete->bindValue(":publie", $article->isPublie(), PDO::PARAM_BOOL);
            $requete->bindValue(":utilisateur_id", $article->getAuteurId(), PDO::PARAM_INT);
            $requete->execute();

            $id = (int) $connexion->lastInsertId();
            $article->setId($id);

            $this->majTagsArticle($article, $connexion);

            $connexion->commit();
        }
        catch (PDOException $e)
        {
            if ($connexion->inTransaction())
            {
                $connexion->rollBack();
            }

            throw $e;
        }
    }

    public function update(Article $article): int
    {
        try
        {
            $connexion = $this->getConnexion();

            $connexion->beginTransaction();

            $requete = $connexion->prepare("UPDATE article SET titre = :titre, texte = :texte, date_modification = NOW(), publie = :publie WHERE id = :id");
            $requete->bindValue(":titre", $article->getTitre(), PDO::PARAM_STR);
            $requete->bindValue(":texte", $article->getTexte(), PDO::PARAM_STR);
            $requete->bindValue(":publie", $article->isPublie(), PDO::PARAM_BOOL);
            $requete->bindValue(":id", $article->getId(), PDO::PARAM_INT);
            $requete->execute();

            $this->majTagsArticle($article, $connexion);

            $nbLignesAffectees = $requete->rowCount();

            $connexion->commit();

            return $nbLignesAffectees;
        }
        catch (PDOException $e)
        {
            if ($connexion->inTransaction())
            {
                $connexion->rollBack();
            }
            throw $e;
        }
    }

    public function delete(int $id): int
    {
        $connexion = $this->getConnexion();

        $requete = $connexion->prepare("DELETE FROM article WHERE id = :id");
        $requete->bindValue(":id", $id, PDO::PARAM_INT);
        $requete->execute();

        return $requete->rowCount();
    }

    private function construireArticle(array $enregistrement): Article
    {
        $article = new Article(
            $enregistrement["titre"],
            $enregistrement["texte"],
            $enregistrement["utilisateur_id"],
            $enregistrement["publie"],
            new DateTime($enregistrement["date_creation"]),
            new DateTime($enregistrement["date_modification"]),
            $enregistrement["id"]
        );

        $auteur = new Utilisateur(
            $enregistrement["nom_utilisateur"],
            $enregistrement["nom"],
            $enregistrement["prenom"],
            $enregistrement["courriel"],
            $enregistrement["role_id"],
            $enregistrement["hash"],
            $enregistrement["chemin_avatar"],
            $enregistrement["utilisateur_id"]
        );
        $article->setAuteur($auteur);

        $role = new Role(
            $enregistrement['role_nom'],
            $enregistrement['role_id']
        );
        $auteur->setRole($role);

        return $article;
    }

    private function recupererTags(Article $article, PDO $connexion): void
    {
        $requete = $connexion->prepare("SELECT
                                            t.id,
                                            t.nom
                                        FROM article_tag AS at 
                                            INNER JOIN tag AS t
                                            ON at.tag_id = t.id 
                                        WHERE at.article_id = :article_id 
                                        ORDER BY t.nom ASC");
        $requete->bindValue(":article_id", $article->getId(), PDO::PARAM_INT);
        $requete->execute();

        $tags = [];
        while ($enregistrement = $requete->fetch(PDO::FETCH_ASSOC))
        {
            $tags[] = new Tag($enregistrement["nom"], $enregistrement["id"]);
        }
        $article->setTags($tags);
    }

    private function majTagsArticle(Article $article, PDO $connexion): void
    {
        // Dans un premier temps, suppression des anciens tags
        $requete = $connexion->prepare("DELETE FROM article_tag WHERE article_id = :article_id");
        $requete->bindValue(":article_id", $article->getId(), PDO::PARAM_INT);
        $requete->execute();

        // Dans un deuxième temps, ajout des nouveaux tags
        $requete = $connexion->prepare("INSERT INTO article_tag(article_id, tag_id) VALUES(:article_id, :tag_id)");
        foreach ($article->getTags() as $tag)
        {
            $requete->bindValue(":article_id", $article->getId(), PDO::PARAM_INT);
            $requete->bindValue(":tag_id", $tag->getId(), PDO::PARAM_INT);
            $requete->execute();
        }
    }
}
