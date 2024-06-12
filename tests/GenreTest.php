<?php

use PHPUnit\Framework\TestCase;
use Entity\Genre;
use Entity\Exception\EntityNotFoundException;
use Database\MyPdo;

class GenreTest extends TestCase
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

        $this->pdo->exec('DELETE FROM genre');

        $this->pdo->exec("
            INSERT INTO genre (name) VALUES 
            ('Action'),
            ('Drama')
        ");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test
        $this->pdo->exec('DELETE FROM genre');
    }

    public function testFindById()
    {
        $genre = Genre::findById(1);

        $this->assertInstanceOf(Genre::class, $genre);
        $this->assertSame(1, $genre->getId());
        $this->assertSame('Action', $genre->getName());
    }

    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Genre - Le genre (id: 999) n'existe pas");

        Genre::findById(999);
    }
}
