<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\TVShowCollection;
use Entity\TVShow;
use Database\MyPdo;

class TVShowCollectionTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = MyPdo::getInstance();

        // Créez les tables et insérez des données de test
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS tvshow (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                originalName TEXT NOT NULL,
                homepage TEXT NOT NULL,
                overview TEXT NOT NULL,
                posterId INTEGER
            );
        ');

        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS tvshow_genre (
                tvShowId INTEGER NOT NULL,
                genreId INTEGER NOT NULL,
                PRIMARY KEY (tvShowId, genreId)
            );
        ');

        $this->pdo->exec('DELETE FROM tvshow');
        $this->pdo->exec('DELETE FROM tvshow_genre');

        $this->pdo->exec("
            INSERT INTO tvshow (name, originalName, homepage, overview, posterId) VALUES 
            ('Breaking Bad', 'Breaking Bad', 'http://breakingbad.com', 'A high school chemistry teacher turned methamphetamine producer.', NULL),
            ('Game of Thrones', 'Game of Thrones', 'http://gameofthrones.com', 'Nine noble families fight for control over the lands of Westeros.', NULL),
            ('Friends', 'Friends', 'http://friends.com', 'Follows the personal and professional lives of six twenty to thirty-something-year-old friends living in Manhattan.', NULL)
        ");

        $this->pdo->exec("
            INSERT INTO tvshow_genre (tvShowId, genreId) VALUES 
            (1, 1),
            (2, 1),
            (2, 2),
            (3, 3)
        ");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test
        $this->pdo->exec('DELETE FROM tvshow');
        $this->pdo->exec('DELETE FROM tvshow_genre');
    }

    public function testFindAll()
    {
        $shows = TVShowCollection::findAll();

        $this->assertIsArray($shows);
        $this->assertCount(3, $shows);
        $this->assertInstanceOf(TVShow::class, $shows[0]);
        $this->assertSame('Breaking Bad', $shows[0]->getName());
        $this->assertSame('Game of Thrones', $shows[1]->getName());
        $this->assertSame('Friends', $shows[2]->getName());
    }

    public function testFindByGenreId()
    {
        $shows = TVShowCollection::findByGenreId(1);

        $this->assertIsArray($shows);
        $this->assertCount(2, $shows);
        $this->assertInstanceOf(TVShow::class, $shows[0]);
        $this->assertSame('Breaking Bad', $shows[0]->getName());
        $this->assertSame('Game of Thrones', $shows[1]->getName());
    }

    public function testFindByGenreIdReturnsEmptyArrayIfNoneFound()
    {
        $shows = TVShowCollection::findByGenreId(999);

        $this->assertIsArray($shows);
        $this->assertCount(0, $shows);
    }

    public function testFindTVShowByResearch()
    {
        $shows = TVShowCollection::findTVShowByResearch('Game');

        $this->assertIsArray($shows);
        $this->assertCount(1, $shows);
        $this->assertInstanceOf(TVShow::class, $shows[0]);
        $this->assertSame('Game of Thrones', $shows[0]->getName());
    }

    public function testFindTVShowByResearchReturnsEmptyArrayIfNoneFound()
    {
        $shows = TVShowCollection::findTVShowByResearch('NonExistingShow');

        $this->assertIsArray($shows);
        $this->assertCount(0, $shows);
    }
}
