<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\TVShow;
use PDO;

class TVShowCollection
{
    /**
     * @return TVShow[]
     */
    public static function findAll(): array
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                ORDER BY name;
            SQL
        );
        $requete->execute();
        return $requete->fetchAll(\PDO::FETCH_CLASS, TVShow::class);
    }

    /**
     * @param int $genreId
     * @return TVShow[]
     * @throws EntityNotFoundException
     */
    public static function findByGenreId(int $genreId) : array
    {
        $stmtShow = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                WHERE id IN 
                (SELECT tvShowId 
                 FROM tvshow_genre
                 WHERE genreId = :genreId)
            SQL
        );
        $stmtShow->execute(["genreId"=>$genreId]);
        return $stmtShow->fetchAll(PDO::FETCH_CLASS, TVShow::class);
    }

    public static function findTVShowByResearch(string $research): array
    {
        $requeteResearch = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                WHERE UPPER(name) LIKE :research
                ORDER BY name
            SQL
        );
        $research = '%'.strtoupper($research).'%';
        $requeteResearch->execute(['research' => $research]);

        return $requeteResearch->fetchAll(\PDO::FETCH_CLASS, TVShow::class);
    }
}



