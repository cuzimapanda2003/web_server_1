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
        "SELECT * FROM article"
    );

    // Aucune configuration... puisqu'aucun paramètre n'est passé à la requête

    // Exécution de la requête
    $requete->execute();

    /// Tant qu'il y a des résultats
    while ($article = $requete->fetch(PDO::FETCH_ASSOC))
    {
        // Affichage des informations de l'article
        echo "==============================\n";
        echo "Id : " . $article['id'] . "\n";
        echo "Titre : " . $article['titre'] . "\n";
        echo "Texte : " . $article['texte'] . "\n";
        echo "Création : " . $article['date_creation'] . "\n";
        echo "Modification : " . $article['date_modification'] . "\n";
        echo "Publié? : " . ($article['publie'] ? "Oui" : "Non") . "\n";
        echo "Id auteur : " . $article['utilisateur_id'] . "\n";
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