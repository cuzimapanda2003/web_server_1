<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "utils.php";

use PHPUnit\Framework\TestCase;

final class CommentaireTest extends TestCase
{
    public function testCommentaireValide(): void
    {
        $date = new DateTime();
        $commentaire = new Commentaire("Texte", 1, 2, $date, 1);
        $this->assertEquals("Texte", $commentaire->getTexte());
        $this->assertEquals(1, $commentaire->getAuteurId());
        $this->assertEquals(2, $commentaire->getArticleId());
        $this->assertEquals($date, $commentaire->getDatePublication());
        $this->assertEquals(1, $commentaire->getId());
        $this->assertEquals(null, $commentaire->getAuteur());
    }

    public function testTexteNonValide1(): void
    {
        $this->expectException(Exception::class);
        $commentaire = new Commentaire(creerChaineDeTest(65536), 1, 2, new DateTime(), 1);
    }

    public function testTexteNonValide2(): void
    {
        $this->expectException(Exception::class);
        $commentaire = new Commentaire("", 1, 2, new DateTime(), 1);
    }
}