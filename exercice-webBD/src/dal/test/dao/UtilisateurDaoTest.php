<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "ParentDaoTest.php";

use PHPUnit\Framework\TestCase;

final class UtilisateurDaoTest extends ParentDaoTest
{
    private UtilisateurDao $utilisateurDao;

    public function setUp(): void
    {
        parent::setUp();
        $this->utilisateurDao = new UtilisateurDao($this->connexionBd);
    }

    public function testSelect()
    {
        $utilisateur = $this->utilisateurDao->select(1);
        $this->assertEquals(1, $utilisateur->getId());
        $this->assertEquals("root", $utilisateur->getNomUtilisateur());
        $this->assertEquals("root", $utilisateur->getNom());
        $this->assertEquals("root", $utilisateur->getPrenom());
        $this->assertEquals("root@gmail.com", $utilisateur->getCourriel());
        $this->assertEquals(1, $utilisateur->getRoleId());
        $this->assertEquals('$2y$10$HYeLAxdInF2N6tGbYKYqBOpAcnXyPX9.hgHMnjb7PJOUnlqUm7Qqu', $utilisateur->getHash());
        $this->assertEquals(null, $utilisateur->getCheminAvatar());
        $this->assertNotNull($utilisateur->getRole());
        $this->assertEquals(1, $utilisateur->getRole()->getId());

        $utilisateur = $this->utilisateurDao->select(100);
        $this->assertEquals(null, $utilisateur);
    }

    public function testSelectParNomUtilisateur()
    {
        $utilisateur = $this->utilisateurDao->selectParNomUtilisateur("tremblayj");
        $this->assertEquals(2, $utilisateur->getId());
        $this->assertEquals("tremblayj", $utilisateur->getNomUtilisateur());
        $this->assertEquals("Tremblay", $utilisateur->getNom());
        $this->assertEquals("Jean", $utilisateur->getPrenom());
        $this->assertEquals("tremblayj@gmail.com", $utilisateur->getCourriel());
        $this->assertEquals(2, $utilisateur->getRoleId());
        $this->assertEquals('$2y$10$BVjmnMgch0a0jqJKbFWmGeel/IlQkNtnwGkJb8dAUvaAJuFo72VnO', $utilisateur->getHash());
        $this->assertEquals('assets/img/troll.png', $utilisateur->getCheminAvatar());
        $this->assertNotNull($utilisateur->getRole());
        $this->assertEquals(2, $utilisateur->getRole()->getId());

        $utilisateur = $this->utilisateurDao->selectParNomUtilisateur("nom_utilisateur_inexistant");
        $this->assertEquals(null, $utilisateur);
    }
}