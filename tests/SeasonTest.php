<?php

use PHPUnit\Framework\TestCase;
use Entity\Season;
use Entity\Exception\EntityNotFoundException;
use Database\MyPdo;

class SeasonTest extends TestCase
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
            (1, 'Season 2', 2, NULL)
        ");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test
        $this->pdo->exec('DELETE FROM season');
    }

    public function testFindById()
    {
        $season = Season::findById(1);

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

        Season::findById(999);
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
