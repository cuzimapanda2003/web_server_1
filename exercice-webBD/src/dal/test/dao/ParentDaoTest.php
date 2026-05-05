<?php

declare(strict_types=1);

require_once "autoloader.php";

use PHPUnit\Framework\TestCase;

abstract class ParentDaoTest extends TestCase
{
    protected ConnexionBd $connexionBd;

    // Permet de réinitialiser la base de données avant chaque test
    public function setUp() : void
    {
        $this->connexionBd = new ConnexionBd("blogue", "etd", "shawi", "localhost");
        echo exec("mysql -u etd --password=shawi < test/dao/blogue.sql");
    }
}