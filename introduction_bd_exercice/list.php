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

    // Construction de la requête préparée
    $requete = $connexion->prepare(
        "SELECT * FROM commentaire"
    );

    // Aucune configuration... puisqu'aucun paramètre n'est passé à la requête

    // Exécution de la requête
    $requete->execute();

    /// Tant qu'il y a des résultats
    while ($commentaire = $requete->fetch(PDO::FETCH_ASSOC))
    {
        // Affichage des informations de l'article
        echo "==============================\n";
        echo "Id : " . $commentaire['id'] . "\n";
        echo "Texte : " . $commentaire['texte'] . "\n";
        echo "date creation : " . $commentaire['date_publication'] . "\n";
        echo "article id : " . $commentaire['article_id'] . "\n";
         echo "utilisateur id : " . $commentaire['utilisateur_id'] . "\n";
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