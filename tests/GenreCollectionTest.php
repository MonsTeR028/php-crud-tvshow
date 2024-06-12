<?php

use PHPUnit\Framework\TestCase;
use Entity\Collection\GenreCollection;
use Entity\Genre;
use Database\MyPdo;

class GenreCollectionTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = MyPdo::getInstance();

        // Créez les tables et insérez des données de test
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS genre (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL
            );
        ');

        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS tvshow_genre (
                tvShowId INTEGER NOT NULL,
                genreId INTEGER NOT NULL,
                PRIMARY KEY(tvShowId, genreId)
            );
        ');

        $this->pdo->exec('DELETE FROM genre');
        $this->pdo->exec('DELETE FROM tvshow_genre');

        $this->pdo->exec("
            INSERT INTO genre (name) VALUES 
            ('Drama'),
            ('Comedy'),
            ('Action')
        ");

        $this->pdo->exec("
            INSERT INTO tvshow_genre (tvShowId, genreId) VALUES 
            (1, 1),
            (1, 2),
            (2, 3)
        ");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test
        $this->pdo->exec('DELETE FROM genre');
        $this->pdo->exec('DELETE FROM tvshow_genre');
    }

    public function testFindAll()
    {
        $genres = GenreCollection::findAll();

        $this->assertIsArray($genres);
        $this->assertCount(3, $genres);
        $this->assertInstanceOf(Genre::class, $genres[0]);
        $this->assertSame('Action', $genres[0]->getName());
        $this->assertSame('Comedy', $genres[1]->getName());
        $this->assertSame('Drama', $genres[2]->getName());
    }

    public function testFindByTVShowId()
    {
        $genres = GenreCollection::findByTVShowId(1);

        $this->assertIsArray($genres);
        $this->assertCount(2, $genres);
        $this->assertInstanceOf(Genre::class, $genres[0]);
        $this->assertSame('Drama', $genres[0]->getName());
        $this->assertSame('Comedy', $genres[1]->getName());
    }

    public function testFindByTVShowIdReturnsEmptyArrayIfNoneFound()
    {
        $genres = GenreCollection::findByTVShowId(999);

        $this->assertIsArray($genres);
        $this->assertCount(0, $genres);
    }
}
