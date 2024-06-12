<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\TVShowCollection;
use Entity\TVShow;

class TVShowCollectionTest extends TestCase
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

        // Créer la table tvshow
        $db->exec('CREATE TABLE IF NOT EXISTS tvshow (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            originalName TEXT NOT NULL,
            homepage TEXT NOT NULL,
            overview TEXT NOT NULL,
            posterId INTEGER
        )');

        // Créer la table tvshow_genre
        $db->exec('CREATE TABLE IF NOT EXISTS tvshow_genre (
            tvShowId INTEGER NOT NULL,
            genreId INTEGER NOT NULL,
            PRIMARY KEY (tvShowId, genreId)
        )');
    }

    private function insertTestData()
    {
        $db = new SQLite3($this->dbFile);

        // Insérer des données de test
        $stmt = $db->prepare("INSERT INTO tvshow (name, originalName, homepage, overview, posterId) VALUES (:name, :originalName, :homepage, :overview, :posterId)");
        $stmt->bindValue(':name', 'Breaking Bad');
        $stmt->bindValue(':originalName', 'Breaking Bad');
        $stmt->bindValue(':homepage', 'http://breakingbad.com');
        $stmt->bindValue(':overview', 'A high school chemistry teacher turned methamphetamine producer.');
        $stmt->bindValue(':posterId', null);
        $stmt->execute();

        $stmt->bindValue(':name', 'Game of Thrones');
        $stmt->bindValue(':originalName', 'Game of Thrones');
        $stmt->bindValue(':homepage', 'http://gameofthrones.com');
        $stmt->bindValue(':overview', 'Nine noble families fight for control over the lands of Westeros.');
        $stmt->bindValue(':posterId', null);
        $stmt->execute();

        $stmt->bindValue(':name', 'Friends');
        $stmt->bindValue(':originalName', 'Friends');
        $stmt->bindValue(':homepage', 'http://friends.com');
        $stmt->bindValue(':overview', 'Follows the personal and professional lives of six twenty to thirty-something-year-old friends living in Manhattan.');
        $stmt->bindValue(':posterId', null);
        $stmt->execute();

        // Insérer des données dans la table tvshow_genre
        $stmt = $db->prepare("INSERT INTO tvshow_genre (tvShowId, genreId) VALUES (:tvShowId, :genreId)");

        $stmt->bindValue(':tvShowId', 1);
        $stmt->bindValue(':genreId', 1);
        $stmt->execute();

        $stmt->bindValue(':tvShowId', 2);
        $stmt->bindValue(':genreId', 1);
        $stmt->execute();

        $stmt->bindValue(':tvShowId', 2);
        $stmt->bindValue(':genreId', 2);
        $stmt->execute();

        $stmt->bindValue(':tvShowId', 3);
        $stmt->bindValue(':genreId', 3);
        $stmt->execute();
    }

    public function testFindAll()
    {
        $shows = TVShowCollection::findAll($this->dbFile);

        $this->assertIsArray($shows);
        $this->assertCount(3, $shows);
        $this->assertInstanceOf(TVShow::class, $shows[0]);
        $this->assertSame('Breaking Bad', $shows[0]->getName());
        $this->assertSame('Game of Thrones', $shows[1]->getName());
        $this->assertSame('Friends', $shows[2]->getName());
    }

    public function testFindByGenreId()
    {
        $shows = TVShowCollection::findByGenreId(1, $this->dbFile);

        $this->assertIsArray($shows);
        $this->assertCount(2, $shows);
        $this->assertInstanceOf(TVShow::class, $shows[0]);
        $this->assertSame('Breaking Bad', $shows[0]->getName());
        $this->assertSame('Game of Thrones', $shows[1]->getName());
    }

    public function testFindByGenreIdReturnsEmptyArrayIfNoneFound()
    {
        $shows = TVShowCollection::findByGenreId(999, $this->dbFile);

        $this->assertIsArray($shows);
        $this->assertCount(0, $shows);
    }

    public function testFindTVShowByResearch()
    {
        $shows = TVShowCollection::findTVShowByResearch('Game', $this->dbFile);

        $this->assertIsArray($shows);
        $this->assertCount(1, $shows);
        $this->assertInstanceOf(TVShow::class, $shows[0]);
        $this->assertSame('Game of Thrones', $shows[0]->getName());
    }

    public function testFindTVShowByResearchReturnsEmptyArrayIfNoneFound()
    {
        $shows = TVShowCollection::findTVShowByResearch('NonExistingShow', $this->dbFile);

        $this->assertIsArray($shows);
        $this->assertCount(0, $shows);
    }
}
