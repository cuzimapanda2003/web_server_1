<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "ParentDaoTest.php";

use PHPUnit\Framework\TestCase;

final class CommentaireDaoTest extends ParentDaoTest
{
    private CommentaireDao $commentaireDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->commentaireDao = new CommentaireDao($this->connexionBd);
    }

    public function testSelectAllParArticleId()
    {
        $commentaires = $this->commentaireDao->selectAllParArticleId(1);
        $this->assertEquals(2, count($commentaires));

        $this->assertEquals(1, $commentaires[0]->getId());
        $this->assertEquals("J'ai une plume magnifique!", $commentaires[0]->getTexte());
        $this->assertEquals(new DateTime("2022-02-06 12:55:16"), $commentaires[0]->getDatePublication());
        $this->assertEquals(1, $commentaires[0]->getArticleId());
        $this->assertEquals(2, $commentaires[0]->getAuteurId());
        $this->assertNotNull($commentaires[0]->getAuteur());
        $this->assertEquals(2, $commentaires[0]->getAuteur()->getId());

        $this->assertEquals(2, $commentaires[1]->getId());
        $this->assertEquals("Oui, c'est vrai!", $commentaires[1]->getTexte());
        $this->assertEquals(new DateTime("2022-02-07 06:35:40"), $commentaires[1]->getDatePublication());
        $this->assertEquals(1, $commentaires[1]->getArticleId());
        $this->assertEquals(3, $commentaires[1]->getAuteurId());
        $this->assertNotNull($commentaires[1]->getAuteur());
        $this->assertEquals(3, $commentaires[1]->getAuteur()->getId());

        $commentaires = $this->commentaireDao->selectAllParArticleId(100);
        $this->assertEquals(0, count($commentaires));
    }

    public function testInsert()
    {
        $commentaire = new Commentaire("Nouveau commentaire", 2, 1);

        $this->commentaireDao->insert($commentaire);
        
        $this->assertEquals(8, $commentaire->getId());
        $commentaires = $this->commentaireDao->selectAllParArticleId($commentaire->getArticleId());
        $this->assertEquals(3, count($commentaires));

        $this->assertEquals("Nouveau commentaire", $commentaires[2]->getTexte());
        $this->assertNotNull($commentaires[2]->getDatePublication());
        $this->assertEquals(1, $commentaires[2]->getArticleId());
        $this->assertEquals(2, $commentaires[2]->getAuteurId());
        $this->assertNotNull($commentaires[2]->getAuteur());
        $this->assertEquals(2, $commentaires[2]->getAuteur()->getId());
    }

    public function testDelete()
    {
        $this->commentaireDao->delete(2);

        $commentaires = $this->commentaireDao->selectAllParArticleId(1);
        $this->assertEquals(1, count($commentaires));

        $this->assertEquals("J'ai une plume magnifique!", $commentaires[0]->getTexte());
        $this->assertEquals(new DateTime("2022-02-06 12:55:16"), $commentaires[0]->getDatePublication());
        $this->assertEquals(1, $commentaires[0]->getArticleId());
        $this->assertEquals(2, $commentaires[0]->getAuteurId());
        $this->assertNotNull($commentaires[0]->getAuteur());
        $this->assertEquals(2, $commentaires[0]->getAuteur()->getId());
    }
}