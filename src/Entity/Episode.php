<?php

namespace Entity;

class Episode
{
    private int $id;
    private int $seasonId;
    private string $name;
    private string $overview;
    private int $episodeNumber;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getSeasonId(): int
    {
        return $this->seasonId;
    }

    public function setSeasonId(int $seasonId): void
    {
        $this->seasonId = $seasonId;
    }

    public function getEpisodeNumber(): int
    {
        return $this->episodeNumber;
    }

    public function setEpisodeNumber(int $episodeNumber): void
    {
        $this->episodeNumber = $episodeNumber;
    }

    public function getOverview(): string
    {
        return $this->overview;
    }

    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
