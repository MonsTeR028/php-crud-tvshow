<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Season
{
    private int $id;
    private int $tvShowId;
    private string $name;
    private int $seasonNumber;
    private ?int $posterId;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTvShowId(): int
    {
        return $this->tvShowId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSeasonNumber(): int
    {
        return $this->seasonNumber;
    }

    public function getPosterId(): ?int
    {
        return $this->posterId;
    }

    public static function findById(int $id): Season
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM season
                WHERE id = :id
            SQL
        );
        $requete->execute(['id' => $id]);
        $resultat = $requete->fetchObject(Season::class);
        if ($resultat == null) {
            throw new EntityNotFoundException("Season - La saison (id: {$id}) n'existe pas");
        }
        return $resultat;
    }
}
