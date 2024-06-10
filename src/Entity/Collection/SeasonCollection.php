<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Season;

class SeasonCollection
{
    /**
     * @param int $id
     * @return Season[]
     */
    public static function findByTVShowId(int $id): array
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM season
                WHERE tvShowId = :tvShowId
                ORDER BY seasonNumber
            SQL
        );
        $requete->execute(['tvShowId' => $id]);
        return $requete->fetchAll(\PDO::FETCH_CLASS, Season::class);
    }
}