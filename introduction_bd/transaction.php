<?php
try
{
    $connexion = new PDO(
        "mysql:host=localhost;dbname=blogue;charset=utf8mb4",
        "etd",
        "shawi",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        )
    );

    // Débute la transaction : Désactive la validation automatique des requêtes (autocommit).
    $connexion->beginTransaction();

    // Création de la requête préparée avec des :marqueurs
    $requete = $connexion->prepare(
        "INSERT INTO article (titre, texte, date_creation, date_modification, publie, utilisateur_id) 
         VALUES (:titre, :texte, NOW(), NOW(), :publie, :utilisateur_id)"
    );

    // Configuration de la 1êre requête (on associe des valeurs aux :marqueurs)
    $requete->bindValue(":titre", "Titre 1", PDO::PARAM_STR);
    $requete->bindValue(":texte", "Texte 1", PDO::PARAM_STR);
    $requete->bindValue(":publie", false, PDO::PARAM_BOOL);
    $requete->bindValue(":utilisateur_id", 3, PDO::PARAM_INT);

    // Exécution de la requête
    $requete->execute();

    // On récupère l'id du nouvel article qui a été auto-généré par la BD
    $idDuNouvelArticle = (int) $connexion->lastInsertId();
    echo "L'id en BD du PREMIER article inséré est $idDuNouvelArticle\n";

    // Configuration de la 2e requête (on associe des valeurs aux :marqueurs)
    $requete->bindValue(":titre", "Titre 2", PDO::PARAM_STR);
    $requete->bindValue(":texte", "Texte 2", PDO::PARAM_STR);
    $requete->bindValue(":publie", false, PDO::PARAM_BOOL);
    // NOTE : Pour faire planter la requête, on peut mettre un utilisateur_id inexistant (ex: 100).
    $requete->bindValue(":utilisateur_id", 3, PDO::PARAM_INT); 

    // Exécution de la requête
    $requete->execute();

    // On récupère l'id du nouvel article qui a été auto-généré par la BD
    $idDuNouvelArticle = (int) $connexion->lastInsertId();
    echo "L'id en BD du DEUXIÈME article inséré est $idDuNouvelArticle\n";

    // Met fin à la transaction : à appeler après l'exécution réussie de toutes les requêtes de la transaction.
    $connexion->commit();

    echo "Transaction complétée avec succès.\n";
}
catch (PDOException $e)
{
    echo "Erreur PDO : " . $e->getMessage() . "\n";

    // Vérifie si une transaction est en cours avant d'appeler rollBack()
    if ($connexion->inTransaction())
    {
        // S'il y a une erreur, tout ce qui s'est exécuté après beginTransaction() 
        // et avant le commit() sera annulé avec l'appel de rollBack().
        $connexion->rollBack();

        echo "Transaction annulée.\n";
    }
}
finally
{
    $connexion = null;
}