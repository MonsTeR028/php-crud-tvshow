<?php

namespace Entity\Collection;

use Database\MyPdo;
use Entity\TVShow;

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
}
