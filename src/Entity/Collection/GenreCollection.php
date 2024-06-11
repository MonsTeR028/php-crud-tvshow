<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\Genre;

class GenreCollection
{
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
                WHERE tvShowId = tvShowId
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