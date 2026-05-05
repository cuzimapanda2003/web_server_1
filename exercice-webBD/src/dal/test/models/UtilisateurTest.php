<?php

declare(strict_types=1);

require_once "autoloader.php";
require_once "utils.php"; 

use PHPUnit\Framework\TestCase;

final class UtilisateurTest extends TestCase
{
    public function testUtlisateurValide(): void
    {
        $hash = creerChaineDeTest(255);

        $utilisateur = new Utilisateur("Nom utilisateur", "Nom", "Prenom", "courriel@gmail.com", 1, $hash, null, 1);
        $this->assertEquals("Nom utilisateur", $utilisateur->getNomUtilisateur());
        $this->assertEquals("Nom", $utilisateur->getNom());
        $this->assertEquals("Prenom", $utilisateur->getPrenom());
        $this->assertEquals("courriel@gmail.com", $utilisateur->getCourriel());
        $this->assertEquals(1, $utilisateur->getRoleId());
        $this->assertEquals($hash, $utilisateur->getHash());
        $this->assertEquals(null, $utilisateur->getCheminAvatar());
        $this->assertEquals(1, $utilisateur->getId());
        $this->assertEquals(null, $utilisateur->getRole());
    }

    public function testNomUtilisateurNonValide1(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur(creerChaineDeTest(51), "Nom", "Prenom", "courriel@gmail.com", 1, creerChaineDeTest(255), null, 1);
    }

    public function testNomUtilisateurNonValide2(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("", "Nom", "Prenom", "courriel@gmail.com", 1, creerChaineDeTest(255), null, 1);
    }

    public function testNomNonValide1(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("Nom utilisateur", creerChaineDeTest(51), "Prenom", "courriel@gmail.com", 1, creerChaineDeTest(255), null, 1);
    }

    public function testNomNonValide2(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("Nom utilisateur", "", "Prenom", "courriel@gmail.com", 1, creerChaineDeTest(255), null, 1);
    }

    public function testPrenomNonValide1(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("Nom utilisateur", "Nom", creerChaineDeTest(51), "courriel@gmail.com", 1, creerChaineDeTest(255), null, 1);
    }

    public function testPrenomNonValide2(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("Nom utilisateur", "Nom", "", "courriel@gmail.com", 1, creerChaineDeTest(255), null, 1);
    }

    public function testCourrielNonValide1(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("Nom utilisateur", "Nom", "Prenom", "courrielgmail.com", 1, creerChaineDeTest(255), null, 1);
    }

    public function testCourrielNonValide2(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("Nom utilisateur", "Nom", "Prenom", "", 1, creerChaineDeTest(255), null, 1);
    }

    public function testCourrielNonValide3(): void
    {
        $this->expectException(Exception::class);
        $utilisateur = new Utilisateur("Nom utilisateur", "Nom", "Prenom", creerChaineDeTest(246)."@gmail.com", 1, creerChaineDeTest(255), null, 1);
    }
}