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
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): Genre
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM genre
                WHERE id = :id
            SQL
        );
        $requete->execute(['id' => $id]);
        $resultat = $requete->fetchObject(Genre::class);
        if ($resultat == null) {
            throw new EntityNotFoundException("Genre - Le genre (id: {$id}) n'existe pas");
        }
        return $resultat;
    }
}
