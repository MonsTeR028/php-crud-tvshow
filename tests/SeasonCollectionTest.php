<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\SeasonCollection;
use Entity\Season;

class SeasonCollectionTest extends TestCase
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

        // Créer la table season
        $db->exec('CREATE TABLE IF NOT EXISTS season (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            tvShowId INTEGER NOT NULL,
            name TEXT NOT NULL,
            seasonNumber INTEGER NOT NULL,
            posterId INTEGER
        )');
    }

    private function insertTestData()
    {
        $db = new SQLite3($this->dbFile);

        // Insérer des données de test
        $stmt = $db->prepare("INSERT INTO season (tvShowId, name, seasonNumber, posterId) VALUES (:tvShowId, :name, :seasonNumber, :posterId)");

        $stmt->bindValue(':tvShowId', 1);
        $stmt->bindValue(':name', 'Season 1');
        $stmt->bindValue(':seasonNumber', 1);
        $stmt->bindValue(':posterId', null);
        $stmt->execute();

        $stmt->bindValue(':tvShowId', 1);
        $stmt->bindValue(':name', 'Season 2');
        $stmt->bindValue(':seasonNumber', 2);
        $stmt->bindValue(':posterId', null);
        $stmt->execute();

        $stmt->bindValue(':tvShowId', 2);
        $stmt->bindValue(':name', 'Season 1');
        $stmt->bindValue(':seasonNumber', 1);
        $stmt->bindValue(':posterId', null);
        $stmt->execute();
    }

    public function testFindByTVShowId()
    {
        $seasons = SeasonCollection::findByTVShowId(1, $this->dbFile);

        $this->assertIsArray($seasons);
        $this->assertCount(2, $seasons);
        $this->assertInstanceOf(Season::class, $seasons[0]);
        $this->assertSame(1, $seasons[0]->getSeasonNumber());
        $this->assertSame(2, $seasons[1]->getSeasonNumber());
    }

    public function testFindByTVShowIdReturnsEmptyArrayIfNoneFound()
    {
        $seasons = SeasonCollection::findByTVShowId(999, $this->dbFile);

        $this->assertIsArray($seasons);
        $this->assertCount(0, $seasons);
    }
}
