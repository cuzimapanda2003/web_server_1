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

    // Création de la requête préparée avec des :marqueurs
    $requete = $connexion->prepare(
        "SELECT * FROM commentaire WHERE id = :id"
    );

    // Configuration de la requête (on associe les valeurs aux :marqueurs)
    $requete->bindValue(":id", 3, PDO::PARAM_INT); // Il faut ajuster avec le bon ID...

    // Exécution de la requête
    $requete->execute();

    // S'il y a le résultat recherché
    if ($commentaire = $requete->fetch(PDO::FETCH_ASSOC))
    {
        // Pour voir la différence entre le paramètre PDO::FETCH_ASSOC 
        // et le comportement par défaut (sans paramètre)
        // print_r($article);

        // Affichage des informations de l'article
        echo "==============================\n";
        echo "Id : " . $commentaire['id'] . "\n";
        echo "Texte : " . $commentaire['texte'] . "\n";
        echo "date creation : " . $commentaire['date_publication'] . "\n";
        echo "article id : " . $commentaire['article_id'] . "\n";
         echo "utilisateur id : " . $commentaire['utilisateur_id'] . "\n";
    }
    else
    {
        echo "Aucun résultat récupéré...\n";
    }
}
catch (PDOException $e)
{
    echo "Erreur PDO !: " . $e->getMessage() . "\n";
}
finally
{
    $connexion = null;
}