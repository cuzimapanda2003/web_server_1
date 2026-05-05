


<?php

//mysql -u etd -p
//USE blogue;
//SELECT * FROM article;

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

    // Création de la requête préparée avec des :marqueurs
    $requete = $connexion->prepare(
        "INSERT INTO article (titre, texte, date_creation, date_modification, publie, utilisateur_id) 
         VALUES (:titre, :texte, NOW(), NOW(), :publie, :utilisateur_id)"
    );

    // Configuration de la requête (on associe des valeurs aux :marqueurs)
    $requete->bindValue(":titre", "Le titre de mon article!", PDO::PARAM_STR);
    $requete->bindValue(":texte", "Il était une fois dans l'ouest...", PDO::PARAM_STR);
    $requete->bindValue(":publie", false, PDO::PARAM_BOOL);
    $requete->bindValue(":utilisateur_id", 3, PDO::PARAM_INT);

    // Exécution de la requête
    $requete->execute();

    // On récupère l'id du nouvel article qui a été auto-généré par la BD
    $idDuNouvelArticle = (int) $connexion->lastInsertId();
    echo "L'id en BD du nouvel article est $idDuNouvelArticle\n";
}
catch (PDOException $e)
{
    echo "Erreur PDO !: " . $e->getMessage() . "\n";
}
finally
{
    $connexion = null;
}