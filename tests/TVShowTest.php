<?php

use PHPUnit\Framework\TestCase;
use Entity\TVShow;
use Entity\Exception\EntityNotFoundException;
class TVShowTest extends TestCase
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
        $db->exec('CREATE TABLE tvshow (
            id INTEGER PRIMARY KEY,
            name TEXT,
            originalName TEXT,
            homepage TEXT,
            overview TEXT
        )');
    }

    private function insertTestData()
    {
        $db = new SQLite3($this->dbFile);

        // Insérer des données de test
        $stmt = $db->prepare("INSERT INTO tvshow (name, originalName, homepage, overview) VALUES (:name, :originalName, :homepage, :overview)");
        $stmt->bindValue(':name', 'Test Show');
        $stmt->bindValue(':originalName', 'Test Original');
        $stmt->bindValue(':homepage', 'http://test.com');
        $stmt->bindValue(':overview', 'A test overview');
        $stmt->execute();
    }

    public function testCreateTVShow()
    {
        $tvShow = TVShow::create('Test Show 2', 'Test Original 2', 'http://test2.com', 'Another test overview');

        $this->assertInstanceOf(TVShow::class, $tvShow);
        $this->assertSame('Test Show 2', $tvShow->getName());
        $this->assertSame('Test Original 2', $tvShow->getOriginalName());
        $this->assertSame('http://test2.com', $tvShow->getHomepage());
        $this->assertSame('Another test overview', $tvShow->getOverview());
        $this->assertNull($tvShow->getId());
        $this->assertNull($tvShow->getPosterId());
    }

    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("TVShow - La série TV (id: 999) n'existe pas");

        TVShow::findById(999, $this->dbFile);
    }

    public function testFindById()
    {
        $fetchedShow = TVShow::findById(1, $this->dbFile);

        $this->assertInstanceOf(TVShow::class, $fetchedShow);
        $this->assertSame(1, $fetchedShow->getId());
        $this->assertSame('Test Show', $fetchedShow->getName());
    }

    public function testSaveInsertsNewShow()
    {
        $tvShow = TVShow::create('Test Show 3', 'Test Original 3', 'http://test3.com', 'A third test overview');
        $tvShow->save($this->dbFile);

        $this->assertNotNull($tvShow->getId());
    }

    public function testSaveUpdatesExistingShow()
    {
        $tvShow = TVShow::findById(1, $this->dbFile);
        $tvShow->setName('Updated Show');
        $tvShow->save($this->dbFile);

        $updatedShow = TVShow::findById(1, $this->dbFile);
        $this->assertSame('Updated Show', $updatedShow->getName());
    }

    public function testDelete()
    {
        $tvShow = TVShow::findById(1, $this->dbFile);
        $tvShow->delete($this->dbFile);

        $this->expectException(EntityNotFoundException::class);
        TVShow::findById(1, $this->dbFile);
    }
}
