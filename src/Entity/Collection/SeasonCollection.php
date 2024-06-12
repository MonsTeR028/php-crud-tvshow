<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Season;

class SeasonCollection
{
    /**
     * Permet de récupérer les saisons d'une série
     * @param int $id : identifiant de la série
     * @return Season[] : tableau des saisons de la série
     */
    public static function findByTVShowId(int $id): array
    {
        $seasonStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM season
                WHERE tvShowId = :tvShowId
                ORDER BY seasonNumber
            SQL
        );
        $seasonStmt->execute(['tvShowId' => $id]);
        return $seasonStmt->fetchAll(\PDO::FETCH_CLASS, Season::class);
    }
}
