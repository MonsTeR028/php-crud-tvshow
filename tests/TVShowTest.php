<?php

use PHPUnit\Framework\TestCase;
use Entity\TVShow;
use Entity\Exception\EntityNotFoundException;
use Database\MyPdo;

class TVShowTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = MyPdo::getInstance();

        // Nettoyer les tables avant chaque test.bat
        $this->pdo->exec('DELETE FROM tvshow');

        // Insérer des données de test.bat
        $this->pdo->exec("INSERT INTO tvshow (name, originalName, homepage, overview) VALUES ('Test Show', 'Test Original', 'http://test.bat.com', 'A test.bat overview')");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test.bat
        $this->pdo->exec('DELETE FROM tvshow');
    }

    public function testCreateTVShow()
    {
        $tvShow = TVShow::create('Test Show 2', 'Test Original 2', 'http://test2.com', 'Another test.bat overview');

        $this->assertInstanceOf(TVShow::class, $tvShow);
        $this->assertSame('Test Show 2', $tvShow->getName());
        $this->assertSame('Test Original 2', $tvShow->getOriginalName());
        $this->assertSame('http://test2.com', $tvShow->getHomepage());
        $this->assertSame('Another test.bat overview', $tvShow->getOverview());
        $this->assertNull($tvShow->getId());
        $this->assertNull($tvShow->getPosterId());
    }

    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("TVShow - La série TV (id: 999) n'existe pas");

        TVShow::findById(999);
    }

    public function testFindById()
    {
        $fetchedShow = TVShow::findById(1);

        $this->assertInstanceOf(TVShow::class, $fetchedShow);
        $this->assertSame(1, $fetchedShow->getId());
        $this->assertSame('Test Show', $fetchedShow->getName());
    }

    public function testSaveInsertsNewShow()
    {
        $tvShow = TVShow::create('Test Show 3', 'Test Original 3', 'http://test3.com', 'A third test.bat overview');

        $tvShow->save();

        $this->assertNotNull($tvShow->getId());
    }

    /**
     * @throws EntityNotFoundException
     */
    public function testSaveUpdatesExistingShow()
    {
        $tvShow = TVShow::findById(1);

        $tvShow->setName('Updated Show');
        $tvShow->save();

        $updatedShow = TVShow::findById(1);
        $this->assertSame('Updated Show', $updatedShow->getName());
    }

    /**
     * @throws EntityNotFoundException
     */
    public function testDelete()
    {
        $tvShow = TVShow::findById(1);

        $tvShow->delete();

        $this->expectException(EntityNotFoundException::class);
        TVShow::findById(1);
    }
}

