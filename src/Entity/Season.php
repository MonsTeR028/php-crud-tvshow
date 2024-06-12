<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Season
{
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setTvShowId(int $tvShowId): void
    {
        $this->tvShowId = $tvShowId;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSeasonNumber(int $seasonNumber): void
    {
        $this->seasonNumber = $seasonNumber;
    }

    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }
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

    /**
     * Permet de récupérer une saison en fonction de son identifiant
     * @param int $id : l'identfiant de la saison
     * @return Season : la saison
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): Season
    {
        $seasonStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM season
                WHERE id = :id
            SQL
        );
        $seasonStmt->execute(['id' => $id]);
        $season = $seasonStmt->fetchObject(Season::class);
        if ($season == null) {
            throw new EntityNotFoundException("Season - La saison (id: {$id}) n'existe pas");
        }
        return $season;
    }
}
