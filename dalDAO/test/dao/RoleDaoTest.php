<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "ParentDaoTest.php";

use PHPUnit\Framework\TestCase;

final class RoleDaoTest extends ParentDaoTest
{
    private RoleDao $roleDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->roleDao = new RoleDao($this->connexionBd);
    }

    public function testSelect()
    {
        $role = $this->roleDao->select(1);
        $this->assertEquals("Administrateur", $role->getNom());
        $this->assertEquals(1, $role->getId());

        $role = $this->roleDao->select(2);
        $this->assertEquals("Blogueur", $role->getNom());
        $this->assertEquals(2, $role->getId());

        $role = $this->roleDao->select(100);
        $this->assertEquals(null, $role);
    }

}