<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "ParentDaoTest.php";

use PHPUnit\Framework\TestCase;

final class BlogueDaoTest extends ParentDaoTest
{
    private BlogueDao $blogueDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->blogueDao = new BlogueDao($this->connexionBd);
    }

    public function testSelectAll()
    {
        $blogues = $this->blogueDao->selectAll();
        $this->assertEquals(3, count($blogues));

        $this->assertEquals(1, $blogues[0]->getId());
        $this->assertEquals("Troll", $blogues[0]->getNom());
        $this->assertEquals("Je suis un troll... et je trolle tout le monde, mouhahahahaha!", $blogues[0]->getDescription());
        $this->assertEquals(new DateTime("2022-02-05 06:24:12"), $blogues[0]->getDateCreation());
        $this->assertEquals(2, $blogues[0]->getBlogueurId());
        $this->assertNotNull($blogues[0]->getBlogueur());
        $this->assertEquals(2, $blogues[0]->getBlogueur()->getId());
        $this->assertEquals(0, count($blogues[0]->getArticles()));

        $this->assertEquals(2, $blogues[1]->getId());
        $this->assertEquals("Méli-mélo", $blogues[1]->getNom());
        $this->assertEquals("J'écris sur tout et sur rien...", $blogues[1]->getDescription());
        $this->assertEquals(new DateTime("2022-04-05 07:33:22"), $blogues[1]->getDateCreation());
        $this->assertEquals(3, $blogues[1]->getBlogueurId());
        $this->assertNotNull($blogues[1]->getBlogueur());
        $this->assertEquals(3, $blogues[1]->getBlogueur()->getId());
        $this->assertEquals(0, count($blogues[1]->getArticles()));

        $this->assertEquals(3, $blogues[2]->getId());
        $this->assertEquals("Un blogue vide", $blogues[2]->getNom());
        $this->assertEquals("J'écris jamais d'article...", $blogues[2]->getDescription());
        $this->assertEquals(new DateTime("2022-10-08 09:21:56"), $blogues[2]->getDateCreation());
        $this->assertEquals(4, $blogues[2]->getBlogueurId());
        $this->assertNotNull($blogues[2]->getBlogueur());
        $this->assertEquals(4, $blogues[2]->getBlogueur()->getId());
        $this->assertEquals(0, count($blogues[2]->getArticles()));
    }

    public function testSelect()
    {
        $blogue = $this->blogueDao->select(1);

        $this->assertEquals(1, $blogue->getId());
        $this->assertEquals("Troll", $blogue->getNom());
        $this->assertEquals("Je suis un troll... et je trolle tout le monde, mouhahahahaha!", $blogue->getDescription());
        $this->assertEquals(new DateTime("2022-02-05 06:24:12"), $blogue->getDateCreation());
        $this->assertEquals(2, $blogue->getBlogueurId());
        $this->assertNotNull($blogue->getBlogueur());
        $this->assertEquals(2, $blogue->getBlogueur()->getId());
        $this->assertEquals(0, count($blogue->getArticles()));

        $blogue = $this->blogueDao->select(100);
        $this->assertNull($blogue);
    }

    public function testSelectParBlogueurId()
    {
        $blogue = $this->blogueDao->selectParBlogueurId(2);

        $this->assertEquals(1, $blogue->getId());
        $this->assertEquals("Troll", $blogue->getNom());
        $this->assertEquals("Je suis un troll... et je trolle tout le monde, mouhahahahaha!", $blogue->getDescription());
        $this->assertEquals(new DateTime("2022-02-05 06:24:12"), $blogue->getDateCreation());
        $this->assertEquals(2, $blogue->getBlogueurId());
        $this->assertNotNull($blogue->getBlogueur());
        $this->assertEquals(2, $blogue->getBlogueur()->getId());
        $this->assertEquals(0, count($blogue->getArticles()));

        $blogue = $this->blogueDao->selectParBlogueurId(100);
        $this->assertNull($blogue);
    }
}