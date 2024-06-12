<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Genre
{
    private int $id;
    private string $name;

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Permet de trouver un genre en fonction de son  identifiant
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): Genre
    {
        $genreStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM genre
                WHERE id = :id
            SQL
        );
        $genreStmt->execute(['id' => $id]);
        $genre = $genreStmt->fetchObject(Genre::class);
        if ($genre == null) {
            throw new EntityNotFoundException("Genre - Le genre (id: {$id}) n'existe pas");
        }
        return $genre;
    }
}
