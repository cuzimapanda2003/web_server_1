<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "utils.php";

use PHPUnit\Framework\TestCase;

final class RoleTest extends TestCase
{
    public function testRoleValide(): void
    {
        $role = new Role("Administrateur", 1);
        $this->assertEquals("Administrateur", $role->getNom());
        $this->assertEquals(1, $role->getId());
    }

    public function testNomNonValide1(): void
    {
        $this->expectException(Exception::class);
        $role = new Role(creerChaineDeTest(51), 1);
    }

    public function testNomNonValide2(): void
    {
        $this->expectException(Exception::class);
        $role = new Role("", 1);
    }
}