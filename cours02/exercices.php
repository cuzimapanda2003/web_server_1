<?php
declare(strict_types=0);

//////////////////////////////
/// Affichage et variables ///
//////////////////////////////
            
// Affichez la chaîne de caractère 'Ma première instruction en php!'
echo "Ma première instruction en php!\n";


// Déclarez la chaîne de caractère $var1 contenant 'Apprendre le '

$var1 = "Apprendre le";


// Déclarez la chaîne de caractère $var2 contenant 'php'
$var2 = "php";

/*
Afficher ceci à la console :

$var1=Apprendre le
$var2=php
*/

echo "\$var1=$var1 \n";
echo "\$var2=$var2 \n";


// Faites la concaténation des deux variables et les  
// mettre dans une troisième variable nommée $var3

$var3 = $var1 . " " . $var2 . "\n";


// Afficher le contenu de $var3

echo $var3;

/////////////////////////////////////////////////////
///   Structures conditionnelles et comparaisons  ///
/////////////////////////////////////////////////////
            
// $var4 = Demandez à l'utilisateur d'entrer un nombre et mettez le dans une chaîne

$var4 = (string) readLine("Veuillez entrer un nombre : ");

// $var5 = Demandez à l'utilisateur d'entrer un nombre et mettez le dans un entier (int)

$var5 = (int) readLine("Veuillez entrer un deuxième nombre : ");

// Faites la comparaison avec l'opérateur == et afficher un message
// indiquant si les variables sont égales ou non en valeur (avec un if/else)

if($var4 == $var5){
    echo "$var4 et $var5 ont une valeur identique \n";
}else{
    echo "$var4 et $var5 valeur ne sont pas identique \n";
}
 
// Faites la comparaison avec l'opérateur === et afficher un message
// indiquant si les variables sont égal ou non valeur et type (avec un if/else)
// Techniquement, ça devrait toujours donner false!

if($var4 === $var5){
    echo "$var4 et $var5 ne sont pas de même type et valeur \n";
}else{
    echo "$var4 et $var5 sont de même type et valeur \n";
}
 


 /*
 En php, il est possible de faire des switch/case en utilisant
 une chaîne de caractères comme élément de comparaison. 
 Commencez par demander à l'utilisateur d'entrer une chaîne.
 Ensuite, faites un switch/case avec un cas pour "bonjour" et
 un cas pour "bonsoir". Si la variable correspond à "bonjour", afficher
 "Il fait clair" et si la variable correspond à "bonsoir", afficher
 "Il fait noir". Ayez le cas "default" aussi avec le message : 
 "C'est n'est ni clair ni noir!"
 */

 $var6 = (string) readline("Entrez une chaine : ");
 echo "\n";

 switch($var6){

    case "bonjour":
        echo "Il fait clair \n";
    break;
        
    case "bonsoir":
        echo "il fait noir \n";
    break;

    default:
        echo "Ce n'est ni clair ni noir! \n";
    break;
 }
            
//////////////////////////////
///   Tableaux et boucles  ///
//////////////////////////////

/*
 * Déclarez vous un $tableau associatif nommé $client avec comme clef/valeur:
 * 
 *    Clef   |   Valeur
 * ----------------------
 *    'id'      '12345'
 *    'nom'    'Monchamp' 
 *   'prenom'   'Fred'
 *   'ville'    'Shawinigan'
 */

$tableau = array( 'id' => '12345', 'nom' => 'Blais', 'prenom' => 'Marc', 'ville' => 'Shawinign');
 

 // Affichez le contenu du tableau avec var_dump et print_r
var_dump(print_r($tableau));

 // Obtener la longueur du tableau, mettez le résultat dans 
 // une variable nommée $longueur et afficher le contenu de la variable.

 $longueur = count($tableau);
 echo "$longueur \n";

 // Utilisez une boucle foreach sur le tableau pour 
 // afficher les valeurs : 12345, Monchamp, Fred, Shawinigan.

 echo "afficher les valeurs : ";
 foreach($tableau as $valeur){
    echo $valeur . ", ";
 }
 echo "\n";


 // Supprimer la valeur correspondant à ville, c'est-à-dire 'Shawinigan'
unset($tableau['ville']);

 // Utilisez une boucle foreach sur le tableau 
 // pour afficher les valeurs ainsi que les clefs     
 
 foreach($tableau as $key => $value){

 echo "$key => $value \n";

 }


 // Afficher la clef du tableau associé à la valeur 'Fred' (il y a une fonction pour ça!)
 
 echo array_search("Marc",$tableau);
 echo "\n";
 
 // Encore à l'aide d'une fonction et d'un if/else, 
 // vérifier si la valeur '12345' fait partie du tableau.
 // Afficher un message conséquent.

 function verificationValeur(array $tableau){
 if(array_search('12345', $tableau)){
    echo "12345 est dans le tableau \n";
 }else{
    echo "12345 n'est pas dans le tableau \n";
 }

 }

 verificationValeur($tableau);
            

 //////////////////////////////
 ///        Fonctions       ///
 //////////////////////////////
            
 // Faites une fonction qui prend en paramètre
 // un entier et qui renvoi le cube de cet entier
 /**
  * Fonction calculant le cube d'un entier
  * 
  * @param int $entier L'entier pour lequel calculer le cube
  * 
  * @return int Le cube de l'entier
  */
// Écrire la fonction ici...

function cube(int $entier){
    return $entier*$entier*$entier;
}



// Appelez votre fonction avec la valeur 100 et affichez le résultat

echo cube(100);
echo "\n";

// Appelez votre fonction avec la valeur "34" et afficher le résultat  
// Pour ce faire, vous devez désactiver le mode "strict"   

echo cube("34");
echo "\n";
