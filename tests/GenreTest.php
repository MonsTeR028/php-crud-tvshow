<?php

use PHPUnit\Framework\TestCase;
use Entity\Genre;
use Entity\Exception\EntityNotFoundException;

class GenreTest extends TestCase
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

        // Créer la table genre
        $db->exec('CREATE TABLE IF NOT EXISTS genre (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL
        )');
    }

    private function insertTestData()
    {
        $db = new SQLite3($this->dbFile);

        // Insérer des données de test
        $stmt = $db->prepare("INSERT INTO genre (name) VALUES (:name)");

        $stmt->bindValue(':name', 'Action');
        $stmt->execute();

        $stmt->bindValue(':name', 'Drama');
        $stmt->execute();
    }

    public function testFindById()
    {
        $genre = Genre::findById(1, $this->dbFile);

        $this->assertInstanceOf(Genre::class, $genre);
        $this->assertSame(1, $genre->getId());
        $this->assertSame('Action', $genre->getName());
    }

    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Genre - Le genre (id: 999) n'existe pas");

        Genre::findById(999, $this->dbFile);
    }
}
