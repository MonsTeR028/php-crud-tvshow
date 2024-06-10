<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Episode;

class EpisodeCollection
{
    /**
     * Permets de trouver les épisodes de la saison d'une série en fonction de l'identifiant de cette série
     * @param int $seasonId : l'identifiant de la série dont on veut trouver les épisodes
     * @return array|false : tableau des épisodes de la série
     */
    public function findBySeasonId(int $seasonId): false|array
    {
        $episodeStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
            SELECT *
            FROM episode
            WHERE seasonId =: seasonId
            SQL
        );
        $episodeStmt->execute(['seasonId' => $seasonId]);
        return $episodeStmt->fetchAll(\PDO::FETCH_CLASS, Episode::class);
    }
}
