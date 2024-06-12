<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\GenreCollection;
use Entity\Genre;

class GenreCollectionTest extends TestCase
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

        // Créer la table tvshow_genre
        $db->exec('CREATE TABLE IF NOT EXISTS tvshow_genre (
            tvShowId INTEGER NOT NULL,
            genreId INTEGER NOT NULL,
            PRIMARY KEY(tvShowId, genreId)
        )');
    }

    private function insertTestData()
    {
        $db = new SQLite3($this->dbFile);

        // Insérer des données de test pour la table genre
        $stmt = $db->prepare("INSERT INTO genre (name) VALUES (:name)");

        $stmt->bindValue(':name', 'Drama');
        $stmt->execute();

        $stmt->bindValue(':name', 'Comedy');
        $stmt->execute();

        $stmt->bindValue(':name', 'Action');
        $stmt->execute();

        // Insérer des données de test pour la table tvshow_genre
        $stmt = $db->prepare("INSERT INTO tvshow_genre (tvShowId, genreId) VALUES (:tvShowId, :genreId)");

        $stmt->bindValue(':tvShowId', 1);
        $stmt->bindValue(':genreId', 1);
        $stmt->execute();

        $stmt->bindValue(':tvShowId', 1);
        $stmt->bindValue(':genreId', 2);
        $stmt->execute();

        $stmt->bindValue(':tvShowId', 2);
        $stmt->bindValue(':genreId', 3);
        $stmt->execute();
    }

    public function testFindAll()
    {
        $genres = GenreCollection::findAll($this->dbFile);

        $this->assertIsArray($genres);
        $this->assertCount(3, $genres);
        $this->assertInstanceOf(Genre::class, $genres[0]);
        $this->assertSame('Action', $genres[0]->getName());
        $this->assertSame('Comedy', $genres[1]->getName());
        $this->assertSame('Drama', $genres[2]->getName());
    }

    public function testFindByTVShowId()
    {
        $genres = GenreCollection::findByTVShowId(1, $this->dbFile);

        $this->assertIsArray($genres);
        $this->assertCount(2, $genres);
        $this->assertInstanceOf(Genre::class, $genres[0]);
        $this->assertSame('Drama', $genres[0]->getName());
        $this->assertSame('Comedy', $genres[1]->getName());
    }

    public function testFindByTVShowIdReturnsEmptyArrayIfNoneFound()
    {
        $genres = GenreCollection::findByTVShowId(999, $this->dbFile);

        $this->assertIsArray($genres);
        $this->assertCount(0, $genres);
    }
}
