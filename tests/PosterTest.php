<?php

use PHPUnit\Framework\TestCase;
use Entity\Poster;
use Entity\Exception\EntityNotFoundException;
use Database\MyPdo;

class PosterTest extends TestCase
{
    private $pdo;

    protected function setUp(): void
    {
        $this->pdo = MyPdo::getInstance();

        // Créez les tables et insérez des données de test
        $this->pdo->exec('
            CREATE TABLE IF NOT EXISTS poster (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                jpeg TEXT NOT NULL
            );
        ');

        $this->pdo->exec('DELETE FROM poster');

        $this->pdo->exec("
            INSERT INTO poster (jpeg) VALUES 
            ('poster1.jpg'),
            ('poster2.jpg')
        ");
    }

    protected function tearDown(): void
    {
        // Nettoyer les tables après chaque test
        $this->pdo->exec('DELETE FROM poster');
    }

    public function testFindById()
    {
        $poster = Poster::findById(1);

        $this->assertInstanceOf(Poster::class, $poster);
        $this->assertSame(1, $poster->getId());
        $this->assertSame('poster1.jpg', $poster->getJpeg());
    }

    public function testFindByIdThrowsExceptionIfNotFound()
    {
        $this->expectException(EntityNotFoundException::class);
        $this->expectExceptionMessage("Poster - Le poster (id: 999) n'existe pas");

        Poster::findById(999);
    }

    public function testSettersAndGetters()
    {
        $poster = new Poster();
        $poster->setId(3);
        $poster->setJpeg('poster3.jpg');

        $this->assertSame(3, $poster->getId());
        $this->assertSame('poster3.jpg', $poster->getJpeg());
    }
}
