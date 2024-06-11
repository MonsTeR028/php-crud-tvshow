<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class TVShow
{
    private ?int $id;
    private string $name;
    private string $originalName;
    private string $homepage; // Page du site internet de la série
    private string $overview;
    private int $posterId;

    private function __construct()
    {
        // appelé par le fetch
    }

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
    public function setId(?int $id):void
    {
        $this->id = $id;
    }
    public function setName(string $name):void
    {
        $this->name = $name;
    }
    public function setOriginalName(string $originalName):void
    {
        $this->originalName = $originalName;
    }
    public function setHomepage(string $homepage):void
    {
        $this->homepage = $homepage;
    }
    public function setOverview(string $overview):void
    {
        $this->overview = $overview;
    }
    public function setPosterId(int $posterId):void
    {
        $this->posterId = $posterId;
    }



    /**
     * @throws EntityNotFoundException
     */
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
        $resultat = $requete->fetchObject(TVShow::class);
        if (false === $resultat) {
            throw new EntityNotFoundException("TVShow - La série TV (id: {$id}) n'existe pas");
        }
        return $resultat;
    }

    /**
     * Renvoie l'instance de Poster appartenant à l'id de la classe TVShow
     * @return Poster
     * @throws EntityNotFoundException
     */
    public function findPosterById(): Poster
    {
        return Poster::findById($this->posterId);
    }

    public function delete(): TVShow
    {
        $requeteSupp = MyPdo::getInstance()->prepare(
            <<<'SQL'
                DELETE FROM tvshow
                WHERE id = :id
            SQL
        );
        $requeteSupp->execute(['id' => $this->getId()]);
        $this->setId(null);
        return $this;
    }
}
