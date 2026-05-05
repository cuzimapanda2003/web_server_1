<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "utils.php";

use PHPUnit\Framework\TestCase;

final class BlogueTest extends TestCase
{
    public function testBlogueValide(): void
    {
        $date = new DateTime();
        $blogue = new Blogue("Nom", "Description", 1, $date, 1);
        $this->assertEquals("Nom", $blogue->getNom());
        $this->assertEquals("Description", $blogue->getDescription());
        $this->assertEquals(1, $blogue->getBlogueurId());
        $this->assertEquals($date, $blogue->getDateCreation());
        $this->assertEquals(1, $blogue->getId());
        $this->assertEquals(array(), $blogue->getArticles());
        $this->assertEquals(null, $blogue->getBlogueur());
    }

    public function testNomNonValide1(): void
    {
        $this->expectException(Exception::class);
        $blogue = new Blogue(creerChaineDeTest(256), "Description", 1, new DateTime(), 1);
    }

    public function testNomNonValide2(): void
    {
        $this->expectException(Exception::class);
        $blogue = new Blogue("", "Description", 1, new DateTime(), 1);
    }

    public function testDescriptionNonValide1(): void
    {
        $this->expectException(Exception::class);
        $blogue = new Blogue("Nom", creerChaineDeTest(65536), 1, new DateTime(), 1);
    }

    public function testDescriptionNonValide2(): void
    {
        $this->expectException(Exception::class);
        $blogue = new Blogue("Nom", "", 1, new DateTime(), 1);
    }

    public function testAjouterArticle(): void
    {
        $blogue = new Blogue("Nom", "Description", 1, new DateTime(), 1);
        $article = new Article("Titre", "Texte", 2, true, new DateTime(), new DateTime(), 1);
        $blogue->ajouterArticle($article);
        $this->assertEquals(array($article), $blogue->getArticles());
    }
}