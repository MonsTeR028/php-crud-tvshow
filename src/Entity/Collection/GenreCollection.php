<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Genre;

class GenreCollection
{
    /**
     * Permet de retrouver tout les genres
     * @return array : tableau des genres
     */
    public static function findAll(): array
    {
        $stmtGenre = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM genre
                ORDER BY name
            SQL
        );
        $stmtGenre->execute();
        return $stmtGenre->fetchAll(\PDO::FETCH_CLASS, Genre::class);
    }


    /**
     * Retoruve la liste des genres selon l'identifiant d'une série
     * @param int $tvShowId : l'identifiant de la série
     * @return Genre[] : liste des genres
     * @throws EntityNotFoundException
     */
    public static function findByTVShowId(int $tvShowId): array
    {
        $genreList = [];
        $genreIdStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT genreId
                FROM tvshow_genre
                WHERE tvShowId = :tvShowId
            SQL
        );
        $genreIdStmt->execute(['tvShowId' => $tvShowId]);
        $result = $genreIdStmt->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($result['genreId'] as $genreId) {
            $genreList[] = Genre::findById($genreId);
        }
        return $genreList;
    }
}
