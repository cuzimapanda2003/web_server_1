<?php
require_once 'autoloader.php';

$connexionBd = new ConnexionBd('blogue', 'etd', 'shawi');

$tagDao = new TagDao($connexionBd);

testTagDao($tagDao);

function testTagDao(TagDao $tagDao)
{
    echo "=====================TagDao=====================\n";
    echo "*******Avant insertion*******\n";
    print_r($tagDao->selectAll());
    $tag = new Tag("python");
    $tagDao->insert($tag);

    echo "*******Après insertion / Avant update*******\n";
    print_r($tagDao->selectAll());
    $tag->setNom("PYTHON");
    $nbLignesAffectees = $tagDao->update($tag);
    echo "Nombre de lignes affectées par l'update : $nbLignesAffectees\n";

    echo "*******Après update / Avant suppression*******\n";
    print_r($tagDao->selectAll());
    $nbLignesAffectees = $tagDao->delete($tag->getId());
    echo "Nombre de lignes affectées par la suppression : $nbLignesAffectees\n";

    echo "*******Après suppression*******\n";
    print_r($tagDao->selectAll());
}