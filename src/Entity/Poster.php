<?php

namespace Entity;

use Database\MyPdo;

class Poster
{
    private int $id;
    private string $jpeg;

    public static function findById(int $id) : Poster
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM poster
                WHERE id = :id
            SQL
        );
        $requete->execute([":id" => $id]);
        return $requete->fetchObject(Poster::class);
    }
}