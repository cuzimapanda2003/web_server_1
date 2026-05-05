<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "ParentDaoTest.php";

use PHPUnit\Framework\TestCase;

final class ArticleDaoTest extends ParentDaoTest
{
    private ArticleDao $articleDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->articleDao = new ArticleDao($this->connexionBd);
    }

    public function testSelectAllParUtilisateurId()
    {
        $articles = $this->articleDao->selectAllParUtilisateurId(3);
        $this->assertEquals(2, count($articles));

        $this->assertEquals(2, $articles[0]->getId());
        $this->assertEquals("Ma présentation", $articles[0]->getTitre());
        $this->assertEquals("Bonjour, je me présente, je m'appelle Marie!", $articles[0]->getTexte());
        $this->assertEquals(new DateTime("2022-10-13 08:56:21"), $articles[0]->getDateCreation());
        $this->assertEquals(new DateTime("2022-10-14 10:33:24"), $articles[0]->getDateModification());
        $this->assertEquals(true, $articles[0]->isPublie());
        $this->assertEquals(3, $articles[0]->getAuteurId());
        $this->assertNotNull($articles[0]->getAuteur());
        $this->assertEquals(0, count($articles[0]->getTags()));
        $this->assertEquals(0, count($articles[0]->getCommentaires()));

        $this->assertEquals(3, $articles[1]->getId());
        $this->assertEquals("Constat", $articles[1]->getTitre());
        $this->assertEquals("Finalement, je constate que je n'aime pas avoir un blogue! C'est long écrire... et il faut penser!", $articles[1]->getTexte());
        $this->assertEquals(new DateTime("2022-11-14 04:44:24"), $articles[1]->getDateCreation());
        $this->assertEquals(new DateTime("2022-11-14 04:44:24"), $articles[1]->getDateModification());
        $this->assertEquals(false, $articles[1]->isPublie());
        $this->assertEquals(3, $articles[1]->getAuteurId());
        $this->assertNotNull($articles[1]->getAuteur());
        $this->assertEquals(0, count($articles[1]->getTags()));
        $this->assertEquals(0, count($articles[1]->getCommentaires()));

        $articles = $this->articleDao->selectAllParUtilisateurId(100);
        $this->assertEquals(0, count($articles));
    }

    public function testSelect()
    {
        $article = $this->articleDao->select(1);

        $this->assertEquals(1, $article->getId());
        $this->assertEquals("Mon premier article!", $article->getTitre());
        $this->assertEquals("Ceci est mon premier article. Fin de l'histoire", $article->getTexte());
        $this->assertEquals(new DateTime("2022-02-06 12:25:19"), $article->getDateCreation());
        $this->assertEquals(new DateTime("2022-02-06 12:25:55"), $article->getDateModification());
        $this->assertEquals(true, $article->isPublie());
        $this->assertEquals(2, $article->getAuteurId());
        $this->assertNotNull($article->getAuteur());
        $this->assertEquals(2, $article->getAuteur()->getId());
        $this->assertEquals(2, count($article->getTags()));
        $this->assertEquals(5, $article->getTags()[0]->getId());
        $this->assertEquals(3, $article->getTags()[1]->getId());
        $this->assertEquals(0, count($article->getCommentaires()));

        $article = $this->articleDao->select(100);
        $this->assertNull($article);
    }

    public function testInsert()
    {
        $article = new Article("Nouveau titre", "Nouveau texte", 2, true);
        $tags = [];
        $tags[] = new Tag("Cuisine", 1);
        $tags[] = new Tag("Sport", 2);
        $article->setTags($tags);

        $this->articleDao->insert($article);
        
        $this->assertEquals(4, $article->getId());
        $article = $this->articleDao->select(4);
        $this->assertEquals("Nouveau titre", $article->getTitre());
        $this->assertEquals("Nouveau texte", $article->getTexte());
        $this->assertNotNull($article->getDateCreation());
        $this->assertNotNull($article->getDateModification());
        $this->assertEquals(true, $article->isPublie());
        $this->assertEquals(2, $article->getAuteurId());
        $this->assertNotNull($article->getAuteur());
        $this->assertEquals(2, $article->getAuteur()->getId());
        $this->assertEquals(2, count($article->getTags()));
        $this->assertEquals(1, $article->getTags()[0]->getId());
        $this->assertEquals(2, $article->getTags()[1]->getId());
        $this->assertEquals(0, count($article->getCommentaires()));
    }

    public function testUpdate()
    {
        $article = $this->articleDao->select(1);
        $article->setTitre("Nouveau titre");
        $article->setTexte("Nouveau texte");
        $article->setPublie(false);
        $article->setTags(array());
        $tags = [];
        $tags[] = new Tag("Cuisine", 1);
        $tags[] = new Tag("Sport", 2);
        $article->setTags($tags);

        $this->articleDao->update($article);

        $article = $this->articleDao->select(1);
        $this->assertEquals("Nouveau titre", $article->getTitre());
        $this->assertEquals("Nouveau texte", $article->getTexte());
        $this->assertEquals(new DateTime("2022-02-06 12:25:19"), $article->getDateCreation());
        $this->assertNotNull($article->getDateModification());
        $this->assertEquals(false, $article->isPublie());
        $this->assertEquals(2, $article->getAuteurId());
        $this->assertNotNull($article->getAuteur());
        $this->assertEquals(2, $article->getAuteur()->getId());
        $this->assertEquals(2, count($article->getTags()));
        $this->assertEquals(1, $article->getTags()[0]->getId());
        $this->assertEquals(2, $article->getTags()[1]->getId());
        $this->assertEquals(0, count($article->getCommentaires()));
    }

    public function testDelete()
    {
        $article = $this->articleDao->select(1);
        $this->articleDao->delete($article->getId());

        $article = $this->articleDao->select(1);
        $this->assertNull($article);

        // Nous ne faisons pas de vérifications sur les autres tables (clef étrangères),
        // car les tables sont configurées pour supprimer en cascade.
    }
}