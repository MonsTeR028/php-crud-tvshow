<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\SeasonCollection;
use Entity\Season;
use Database\MyPdo;

class SeasonCollectionTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = MyPdo::getInstance();

        // Créez les tables et insérez des données de test
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS season (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                tvShowId INTEGER NOT NULL,
                name TEXT NOT NULL,
                seasonNumber INTEGER NOT NULL,
                posterId INTEGER
            );
        ');

        $this->pdo->exec('DELETE FROM season');

        $this->pdo->exec("
            INSERT INTO season (tvShowId, name, seasonNumber, posterId) VALUES 
            (1, 'Season 1', 1, NULL),
            (1, 'Season 2', 2, NULL),
            (2, 'Season 1', 1, NULL)
        ");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test
        $this->pdo->exec('DELETE FROM season');
    }

    public function testFindByTVShowId()
    {
        $seasons = SeasonCollection::findByTVShowId(1);

        $this->assertIsArray($seasons);
        $this->assertCount(2, $seasons);
        $this->assertInstanceOf(Season::class, $seasons[0]);
        $this->assertSame(1, $seasons[0]->getSeasonNumber());
        $this->assertSame(2, $seasons[1]->getSeasonNumber());
    }

    public function testFindByTVShowIdReturnsEmptyArrayIfNoneFound()
    {
        $seasons = SeasonCollection::findByTVShowId(999);

        $this->assertIsArray($seasons);
        $this->assertCount(0, $seasons);
    }
}
