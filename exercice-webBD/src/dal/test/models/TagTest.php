<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "utils.php";

use PHPUnit\Framework\TestCase;

final class TagTest extends TestCase
{
    public function testTagValide(): void
    {
        $tag = new Tag("Bonjour", 1);
        $this->assertEquals("Bonjour", $tag->getNom());
        $this->assertEquals(1, $tag->getId());
    }

    public function testNomNonValide1(): void
    {
        $this->expectException(Exception::class);
        $tag = new Tag(creerChaineDeTest(51), 1);
    }

    public function testNomNonValide2(): void
    {
        $this->expectException(Exception::class);
        $tag = new Tag("", 1);
    }
}
