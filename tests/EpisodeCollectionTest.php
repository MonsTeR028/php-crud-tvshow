<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\EpisodeCollection;
use Entity\Episode;

class EpisodeCollectionTest extends TestCase
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

        // Créer la table episode
        $db->exec('CREATE TABLE IF NOT EXISTS episode (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            seasonId INTEGER NOT NULL,
            name TEXT NOT NULL,
            overview TEXT NOT NULL,
            episodeNumber INTEGER NOT NULL
        )');
    }

    private function insertTestData()
    {
        $db = new SQLite3($this->dbFile);

        // Insérer des données de test pour la table episode
        $stmt = $db->prepare("INSERT INTO episode (seasonId, name, overview, episodeNumber) VALUES (:seasonId, :name, :overview, :episodeNumber)");

        $stmt->bindValue(':seasonId', 1);
        $stmt->bindValue(':name', 'Episode 1');
        $stmt->bindValue(':overview', 'Overview 1');
        $stmt->bindValue(':episodeNumber', 1);
        $stmt->execute();

        $stmt->bindValue(':seasonId', 1);
        $stmt->bindValue(':name', 'Episode 2');
        $stmt->bindValue(':overview', 'Overview 2');
        $stmt->bindValue(':episodeNumber', 2);
        $stmt->execute();

        $stmt->bindValue(':seasonId', 2);
        $stmt->bindValue(':name', 'Episode 3');
        $stmt->bindValue(':overview', 'Overview 3');
        $stmt->bindValue(':episodeNumber', 1);
        $stmt->execute();
    }

    public function testFindBySeasonId()
    {
        $episodes = EpisodeCollection::findBySeasonId(1, $this->dbFile);

        $this->assertIsArray($episodes);
        $this->assertCount(2, $episodes);
        $this->assertInstanceOf(Episode::class, $episodes[0]);
        $this->assertSame('Episode 1', $episodes[0]->getName());
        $this->assertSame('Episode 2', $episodes[1]->getName());
    }

    public function testFindBySeasonIdReturnsEmptyArrayIfNoneFound()
    {
        $episodes = EpisodeCollection::findBySeasonId(999, $this->dbFile);

        $this->assertIsArray($episodes);
        $this->assertCount(0, $episodes);
    }
}
