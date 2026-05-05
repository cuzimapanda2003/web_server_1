<?php
try
{
    echo "Tentative d'ouverture d'une connexion à la BD!\n";
    $connexion = new PDO(
        "mysql:host=localhost;dbname=blogue;charset=utf8mb4",
        "etd",
        "shawi",
        array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_FOUND_ROWS => true
        )
    );

    echo "La connexion s'est bien déroulée!\n";
}
catch (PDOException $e)
{
    echo "Erreur PDO : " . $e->getMessage() . "\n";
}
finally
{
    echo "Fermeture de la connexion!\n";
    $connexion = null;
}