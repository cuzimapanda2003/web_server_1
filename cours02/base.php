<?php
// Mettre du code PHP ici!


// MANIPULATION DES ARRAY !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

echo "Manipulation des array \n";
$tabClefsImplicites = array(1, 2, "chaine");
$tabClefsExplicites = array('nom' => 'Tremblay', 'prenom' => 'jean');

echo '$tabClefsImplicites : ' . "\n";
print_r($tabClefsImplicites);
echo '$tabClefsExplicites : ' . "\n";
print_r($tabClefsExplicites);
echo "\n";


// Compter le nombre de valeurs dans un tableau
echo "Count() sert à compter le nombre d'éléments dans un tableau:\n";
echo 'count($tabClefsImplicites) : ' . count($tabClefsImplicites) . "\n";
echo 'count($tabClefsExplicites) : ' . count($tabClefsExplicites) . "\n\n";


// Vérification si un tableau contient une valeur
echo "in_array() sert à vérifier si une valeur est présente dans un tableau:\n";
echo 'if(in_array(\'jean\', $tabClefsExplicites))';
if (in_array('jean', $tabClefsExplicites))
{
    echo "'jean' est présent dans le tableau!\n\n";
}
else
{
    echo "'jean' n'est pas présent dans le tableau!\n\n";
}


// Recherche la clef d'une valeur dans un tableau
echo "array_search() sert à rechercher la clef d'une valeur dans un tableau:\n";
echo "array_search('chaine', \$tabClefsImplicites) : " . array_search('chaine', $tabClefsImplicites) . "\n";
echo "array_search(56, \$tabClefsImplicites) --> non présent (retourne fasle qui n'est pas visible à la console...) : " .  array_search(56, $tabClefsImplicites) . "\n";
echo "array_search('Tremblay', \$tabClefsExplicites) : " .  array_search('Tremblay', $tabClefsExplicites) . "\n\n";


// Vérification si une clef existe dans un tableau
echo "array_key_exists() sert à vérifier si une clef existe dans un tableau:\n";
echo "if(array_key_exists('nom', \$tabClefsExplicites)) : ";
if (array_key_exists('nom', $tabClefsExplicites))
{
    echo "La clef 'nom' existe dans le tableau!\n\n";
}
else
{
    echo "La clef 'nom' n'existe pas dans le tableau!\n\n";
}


// Supprimer un élément d'un tableau à partir de sa clef
echo "unset() sert à supprimer un élément d'un tableau à partir de sa clef:\n";
unset($tabClefsImplicites[1]);
// Observez bien les clefs du tableau après l'exécution de la ligne précédente
// Le décomptage des clefs n'est pas réajusté
echo '$tabClefsImplicites après un unset($tabClefsImplicites[1]) : ' . "\n";
print_r($tabClefsImplicites);
echo "\n";


// Une variable est-elle un tableau?
echo "is_array() sert à vérifier si une variable est un tableau:\n";
echo "if(is_array(\$tabClefsImplicites)) : ";
if (is_array($tabClefsImplicites))
{
    echo "Oui, \$tabClefsImplicites est un tableau!\n";
}
else
{
    echo "Non, \$tabClefsImplicites n'est pas un tableau!\n";
}
echo "---------------------------------------------------------------------------- \n \n";


//for each!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

echo "for each \n \n";

$tabClefsImplicites = array(1, 2, "chaine");
$tabClefsExplicites = array('nom' => 'Tremblay', 'prenom' => 'jean');

foreach($tabClefsImplicites as $valeur)
{
    echo $valeur . "\n";
}

echo "----------------------------\n";

foreach($tabClefsExplicites as $valeur)
{
    echo $valeur . "\n";
}

echo "------------------------- \n \n";


// for each clef valeur!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


echo "for each clef valeur : \n \n";

$tabClefsImplicites = array(1, 2, "chaine");
$tabClefsExplicites = array('nom' => 'Tremblay', 'prenom' => 'jean');

foreach($tabClefsImplicites as $clef => $valeur)
{
    echo "$clef => $valeur \n";
}

echo "-------------\n";

foreach($tabClefsExplicites as $clef => $valeur)
{
    echo "$clef => $valeur \n";
}

echo "------------------------- \n \n";


// lecture console !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!


echo "Lecture a la console : \n \n";


$chaine = readLine("Entrez une chaîne : ");
$entier = (int) readLine("Entrer un entier : ");
$reel = (float) readLine("Entrer un nombre réel : ");

echo "Chaine : $chaine\n";
echo "Entier : $entier\n";
echo "Réel   : $reel\n";

echo "--------------------------------------- \n \n";

// LES FONCTIONS !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

?>
