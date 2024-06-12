<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Entity\TVShow;
use PDO;

class TVShowCollection
{
    /**
     * Permet de récupérer tout les série
     * @return TVShow[] : tableau des séries
     */
    public static function findAll(): array
    {
        $showStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                ORDER BY name;
            SQL
        );
        $showStmt->execute();
        return $showStmt->fetchAll(\PDO::FETCH_CLASS, TVShow::class);
    }

    /**
     * Permet de récupérer les série selon leur genre
     * @param int $genreId : l'identifiant du genre dont on veut les séries
     * @return TVShow[] : tableau des séries
     * @throws EntityNotFoundException
     */
    public static function findByGenreId(int $genreId): array
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
        $stmtShow->execute(["genreId" => $genreId]);
        return $stmtShow->fetchAll(PDO::FETCH_CLASS, TVShow::class);
    }

    /**
     * Permet de retrouver les série selon des mots
     * @param string $research : la recherche
     * @return array : tableau des séries
     */
    public static function findTVShowByResearch(string $research): array
    {
        $stmtShow = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM tvshow
                WHERE UPPER(name) LIKE :research
                ORDER BY name
            SQL
        );
        $research = '%'.strtoupper($research).'%';
        $stmtShow->execute(['research' => $research]);

        return $stmtShow->fetchAll(\PDO::FETCH_CLASS, TVShow::class);
    }
}
