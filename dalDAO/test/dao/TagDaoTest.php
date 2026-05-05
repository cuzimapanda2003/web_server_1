<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "ParentDaoTest.php";

use PHPUnit\Framework\TestCase;

final class TagDaoTest extends ParentDaoTest
{
    private TagDao $tagDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->tagDao = new TagDao($this->connexionBd);
    }

    public function testSelectAllTags()
    {
        $tags = $this->tagDao->selectAll();
        $this->assertEquals(5, count($tags));
        $this->assertEquals("Cuisine", $tags[0]->getNom());
        $this->assertEquals(1, $tags[0]->getId());

        $this->assertEquals("Divers", $tags[1]->getNom());
        $this->assertEquals(5, $tags[1]->getId());

        $this->assertEquals("Économie", $tags[2]->getNom());
        $this->assertEquals(4, $tags[2]->getId());

        $this->assertEquals("Politique", $tags[3]->getNom());
        $this->assertEquals(3, $tags[3]->getId());

        $this->assertEquals("Sport", $tags[4]->getNom());
        $this->assertEquals(2, $tags[4]->getId());
    }

    public function testSelectTag()
    {
        $tag = $this->tagDao->select(1);
        $this->assertEquals("Cuisine", $tag->getNom());
        $this->assertEquals(1, $tag->getId());

        $tag = $this->tagDao->select(100);
        $this->assertEquals(null, $tag);
    }

    public function testSelectByIds()
    {
        $tags = $this->tagDao->selectParIds([3, 1, 2]);
        $this->assertEquals(3, count($tags));
        $this->assertEquals("Politique", $tags[1]->getNom());
        $this->assertEquals(3, $tags[1]->getId());

        $this->assertEquals("Cuisine", $tags[0]->getNom());
        $this->assertEquals(1, $tags[0]->getId());

        $this->assertEquals("Sport", $tags[2]->getNom());
        $this->assertEquals(2, $tags[2]->getId());

        $tags = $this->tagDao->selectParIds([]);
        $this->assertEquals(0, count($tags));

    }

    public function testInsertTag()
    {
        $tag = new Tag("Nouveau tag");
        $this->tagDao->insert($tag);
        $this->assertEquals(6, $tag->getId());
        $tag = $this->tagDao->select(6);
        $this->assertEquals("Nouveau tag", $tag->getNom());
    }

    public function testUpdateTag()
    {
        $tag = new Tag("Nouveau tag");
        $this->tagDao->insert($tag);
        $tag->setNom("Nouveau nom");
        $this->tagDao->update($tag);
        $tag = $this->tagDao->select(6);
        $this->assertEquals("Nouveau nom", $tag->getNom());
    }

    public function testDeleteTag()
    {
        $tag = new Tag("Nouveau tag");
        $this->tagDao->insert($tag);
        $this->tagDao->delete($tag->getId());
        $tag = $this->tagDao->select(6);
        $this->assertNull($tag);
    }
}