<?php

use PHPUnit\Framework\TestCase;
use Entity\Season;
use Entity\Exception\EntityNotFoundException;

class SeasonTest extends TestCase
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
    }

    public function testFindById()
    {
        $season = Season::findById(1, $this->dbFile);

        $this->assertInstanceOf(Season::class, $season);
        $this->assertSame(1, $season->getId());
        $this->assertSame(1, $season->getTvShowId());
        $this->assertSame('Season 1', $season->getName());
        $this->assertSame(1, $season->getSeasonNumber());
        $this->assertNull($season->getPosterId());
    }

    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Season - La saison (id: 999) n'existe pas");

        Season::findById(999, $this->dbFile);
    }

    public function testSettersAndGetters()
    {
        $season = new Season();
        $season->setId(3);
        $season->setTvShowId(1);
        $season->setName('Season 3');
        $season->setSeasonNumber(3);
        $season->setPosterId(2);

        $this->assertSame(3, $season->getId());
        $this->assertSame(1, $season->getTvShowId());
        $this->assertSame('Season 3', $season->getName());
        $this->assertSame(3, $season->getSeasonNumber());
        $this->assertSame(2, $season->getPosterId());
    }
}
