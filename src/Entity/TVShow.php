<?php

namespace Entity;

use Database\MyPdo;

class TVShow
{
    private int $id;
    private string $name;
    private string $originalName;
    private string $homepage; // Page du site internet de la série
    private string $overview;
    private int $posterId;

    public function getId(): int
    {
        return $this->id;
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getOriginalName(): string
    {
        return $this->originalName;
    }
    public function getHomepage(): string
    {
        return $this->homepage;
    }
    public function getOverview(): string
    {
        return $this->overview;
    }
    public function getPosterId(): int
    {
        return $this->posterId;
    }

    public static function findById(int $id): TVShow
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT * 
                FROM tvshow
                WHERE id = :id
            SQL
        );
        $requete->execute(['id' => $id]);
        return $requete->fetchObject(TVShow::class);
    }
}
