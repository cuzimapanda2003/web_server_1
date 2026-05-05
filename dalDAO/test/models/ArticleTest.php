<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "utils.php";

use PHPUnit\Framework\TestCase;

final class ArticleTest extends TestCase
{
    public function testArticleValide(): void
    {
        $creation = new DateTime();
        $modification = new DateTime();

        $article = new Article("Titre", "Texte", 2, true, $creation, $modification, 1);
        $this->assertEquals("Titre", $article->getTitre());
        $this->assertEquals("Texte", $article->getTexte());
        $this->assertEquals(2, $article->getAuteurId());
        $this->assertEquals(true, $article->isPublie());
        $this->assertEquals($creation, $article->getDateCreation());
        $this->assertEquals($modification, $article->getDateModification());
        $this->assertEquals(1, $article->getId());
        $this->assertEquals(array(), $article->getTags());
        $this->assertEquals(array(), $article->getCommentaires());
        $this->assertEquals(null, $article->getAuteur());
    }

    public function testTitreNonValide1(): void
    {
        $this->expectException(Exception::class);
        $article = new Article(creerChaineDeTest(256), "Texte", 2, true, new DateTime(), new DateTime(), 1);
    }

    public function testTitreNonValide2(): void
    {
        $this->expectException(Exception::class);
        $article = new Article("", "Texte", 2, true, new DateTime(), new DateTime(), 1);
    }

    public function testTexteNonValide1(): void
    {
        $this->expectException(Exception::class);
        $article = new Article("Titre", creerChaineDeTest(65536), 2, true, new DateTime(), new DateTime(), 1);
    }

    public function testTexteNonValide2(): void
    {
        $this->expectException(Exception::class);
        $article = new Article("Titre", "", 2, true, new DateTime(), new DateTime(), 1);
    }

    public function testAjouterTag(): void
    {
        $article = new Article("Titre", "Texte", 2, true, new DateTime(), new DateTime(), 1);
        $tag = new Tag("Nom");
        $article->ajouterTag($tag);
        $this->assertEquals(array($tag), $article->getTags());
    }

    public function testAjouterCommentaire(): void
    {
        $article = new Article("Titre", "Texte", 2, true, new DateTime(), new DateTime(), 1);
        $commentaire = new Commentaire("Texte", 2, 2, new DateTime(), 1);
        $article->ajouterCommentaire($commentaire);
        $this->assertEquals(array($commentaire), $article->getCommentaires());
    }
}