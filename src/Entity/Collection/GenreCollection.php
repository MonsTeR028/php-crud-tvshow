<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Genre;

class GenreCollection
{
    /**
     * @return Genre[]
     */
    public static function findAll() : array
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM genre
                ORDER BY name
            SQL
        );
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_CLASS, Genre::class);
    }


    /**
     * @param int $tvShowId
     * @return Genre[]
     * @throws EntityNotFoundException
     */
    public static function findByTVShowId(int $tvShowId) : array
    {
        $listeGenre = [];
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT genreId
                FROM tvshow_genre
                WHERE tvShowId = :tvShowId
            SQL
        );
        $requete->execute(['tvShowId' => $tvShowId]);
        $resultat = $requete->fetchAll(\PDO::FETCH_ASSOC);
        foreach ($resultat['genreId'] as $genreId) {
            $listeGenre[] = Genre::findById($genreId);
        }
        return $listeGenre;
    }
}