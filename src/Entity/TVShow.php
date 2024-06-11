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
    private ?int $posterId;

    private function __construct()
    {
        // appelé par le fetch
    }

    public function getId(): ?int
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
    public function getPosterId(): ?int
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
    public function setPosterId(?int $posterId):void
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
        $requeteSupp->execute(['id' => $this->id]);
        $this->id = null;
        return $this;
    }

    public function update(): TVShow
    {
        $requeteModif = MyPdo::getInstance()->prepare(
            <<<'SQL'
                UPDATE tvshow
                SET name = :name,
                    originalName = :originalName,
                    homepage = :homepage,
                    overview = :overview
                WHERE id = :id
            SQL
        );
        $requeteModif->execute(
            [
                'name' => $this->name,
                'originalName' => $this->originalName,
                'homepage' => $this->homepage,
                'overview' => $this->overview,
                'id' => $this->id
            ]
        );
        return $this;
    }

    public function insert(): TVShow
    {
        $requeteInsert = MyPdo::getInstance()->prepare(
            <<<'SQL'
                INSERT INTO tvshow (name, originalName, homapage, overview)
                VALUES (:name, :originalName, :homepage, :overview)
            SQL
        );
        $requeteInsert->execute(
            [
                'name' => $this->name,
                'originalName' => $this->originalName,
                'homepage' => $this->homepage,
                'overview' => $this->overview
            ]
        );
        $this->id = (int) MyPdo::getInstance()->lastInsertId();
        return $this;
    }

    public function save(): TVShow
    {
        if (null == $this->id) {
            $this->insert();
        } else {
            $this->update();
        }

        return $this;
    }

    public static function create(
        string $name,
        string $originalName,
        string $homepage,
        string $overview,
        ?int $id = null
    ): TVShow {
        $show = new TVShow();
        $show->setId($id);
        $show->setName($name);
        $show->setOriginalName($originalName);
        $show->setHomepage($homepage);
        $show->setOverview($overview);
        return $show;
    }
}
