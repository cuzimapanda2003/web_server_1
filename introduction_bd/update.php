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
        "UPDATE article 
         SET titre = :titre, texte = :texte, date_modification = NOW(), publie = :publie 
         WHERE id = :id"
    );

    // Configuration de la requête (on associe les valeurs aux :marqueurs)
    $requete->bindValue(":titre", "Mon nouveau titre!", PDO::PARAM_STR);
    $requete->bindValue(":texte", "Mon nouveau texte...", PDO::PARAM_STR);
    $requete->bindValue(":publie", true, PDO::PARAM_BOOL);
    $requete->bindValue(":id", 4, PDO::PARAM_INT); // Il faut ajuster avec le bon ID...

    // Exécution de la requête
    $requete->execute();

    // Nous regardons si la modification a été faite
    $nbEnregistrementsAffectes = $requete->rowCount();
    echo "Nombre d'enregistrements affectés : $nbEnregistrementsAffectes\n";
}
catch (PDOException $e)
{
    echo "Erreur PDO !: " . $e->getMessage() . "\n";
}
finally
{
    $connexion = null;
}