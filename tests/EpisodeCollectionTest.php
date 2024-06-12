<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\EpisodeCollection;
use Entity\Episode;
use Database\MyPdo;

class EpisodeCollectionTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = MyPdo::getInstance();

        // Créez les tables et insérez des données de test
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS episode (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                seasonId INTEGER NOT NULL,
                name TEXT NOT NULL,
                overview TEXT NOT NULL,
                episodeNumber INTEGER NOT NULL
            );
        ');

        $this->pdo->exec('DELETE FROM episode');

        $this->pdo->exec("
            INSERT INTO episode (seasonId, name, overview, episodeNumber) VALUES 
            (1, 'Episode 1', 'Overview 1', 1),
            (1, 'Episode 2', 'Overview 2', 2),
            (2, 'Episode 3', 'Overview 3', 1)
        ");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test
        $this->pdo->exec('DELETE FROM episode');
    }

    public function testFindBySeasonId()
    {
        $episodes = EpisodeCollection::findBySeasonId(1);

        $this->assertIsArray($episodes);
        $this->assertCount(2, $episodes);
        $this->assertInstanceOf(Episode::class, $episodes[0]);
        $this->assertSame('Episode 1', $episodes[0]->getName());
        $this->assertSame('Episode 2', $episodes[1]->getName());
    }

    public function testFindBySeasonIdReturnsEmptyArrayIfNoneFound()
    {
        $episodes = EpisodeCollection::findBySeasonId(999);

        $this->assertIsArray($episodes);
        $this->assertCount(0, $episodes);
    }
}
