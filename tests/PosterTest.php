<?php

use PHPUnit\Framework\TestCase;
use Entity\Poster;
use Entity\Exception\EntityNotFoundException;

class PosterTest extends TestCase
{
    private $dbFile = 'tests/test_database.db';

    protected function setUp(): void
    {
        // Créer une nouvelle base de données SQLite
        $this->createDatabase();

        // Insérer des données de test
        $this->insertTestData();
    }

    protected function tearDown(): void
    {
        // Supprimer la base de données SQLite après chaque test
        unlink($this->dbFile);
    }

    private function createDatabase()
    {
        $db = new SQLite3($this->dbFile);

        // Créer la table poster
        $db->exec('CREATE TABLE IF NOT EXISTS poster (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            jpeg TEXT NOT NULL
        )');
    }

    private function insertTestData()
    {
        $db = new SQLite3($this->dbFile);

        // Insérer des données de test
        $stmt = $db->prepare("INSERT INTO poster (jpeg) VALUES (:jpeg)");

        $stmt->bindValue(':jpeg', 'poster1.jpg');
        $stmt->execute();

        $stmt->bindValue(':jpeg', 'poster2.jpg');
        $stmt->execute();
    }

    public function testFindById()
    {
        $poster = Poster::findById(1, $this->dbFile);

        $this->assertInstanceOf(Poster::class, $poster);
        $this->assertSame(1, $poster->getId());
        $this->assertSame('poster1.jpg', $poster->getJpeg());
    }

    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Poster - Le poster (id: 999) n'existe pas");

        Poster::findById(999, $this->dbFile);
    }

    public function testSettersAndGetters()
    {
        $poster = new Poster();
        $poster->setId(3);
        $poster->setJpeg('poster3.jpg');

        $this->assertSame(3, $poster->getId());
        $this->assertSame('poster3.jpg', $poster->getJpeg());
    }
}
