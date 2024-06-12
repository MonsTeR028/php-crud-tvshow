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
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function setOriginalName(string $originalName): void
    {
        $this->originalName = $originalName;
    }
    public function setHomepage(string $homepage): void
    {
        $this->homepage = $homepage;
    }
    public function setOverview(string $overview): void
    {
        $this->overview = $overview;
    }
    public function setPosterId(?int $posterId): void
    {
        $this->posterId = $posterId;
    }


    /**
     * Permet de trouver une série en fonction de son identifiant
     * @param int $id : identifiant de la série
     * @return TVShow : la série
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): TVShow
    {
        $showStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT * 
                FROM tvshow
                WHERE id = :id
            SQL
        );
        $showStmt->execute(['id' => $id]);
        $show = $showStmt->fetchObject(TVShow::class);
        if (false === $show) {
            throw new EntityNotFoundException("TVShow - La série TV (id: {$id}) n'existe pas");
        }
        return $show;
    }

    /**
     * Renvoie l'instance de Poster appartenant à l'id de la classe TVShow
     * @return Poster : le poster
     * @throws EntityNotFoundException
     */
    public function findPosterById(): Poster
    {
        return Poster::findById($this->posterId);
    }

    /**
     * Permet de supprimer une série
     * @return $this : la série supprimée
     */
    public function delete(): TVShow
    {
        $deleteStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                DELETE FROM tvshow
                WHERE id = :id
            SQL
        );
        $deleteStmt->execute(['id' => $this->id]);
        $this->id = null;
        return $this;
    }

    /**
     * Permet de mettre à jour une série
     * @return $this
     */
    public function update(): TVShow
    {
        $updateStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                UPDATE tvshow
                SET name = :name,
                    originalName = :originalName,
                    homepage = :homepage,
                    overview = :overview
                WHERE id = :id
            SQL
        );
        $updateStmt->execute(
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

    /**
     * Permet d'insérer une série
     * @return $this : la série insérée
     */
    public function insert(): TVShow
    {
        $insertStmt = MyPdo::getInstance()->prepare(
            <<<'SQL'
                INSERT INTO tvshow (name, originalName, homepage, overview, posterId)
                VALUES (:name, :originalName, :homepage, :overview, NULL)
            SQL
        );
        $insertStmt->execute(
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

    /**
     * Permet d'insérer ou supprimer une série en fonction de son existence ou non
     * @return $this : la série insérer/supprimer
     */
    public function save(): TVShow
    {
        if (null == $this->id) {
            $this->insert();
        } else {
            $this->update();
        }

        return $this;
    }

    /**
     * Permet de créer une série
     * @param string $name : nom de la série
     * @param string $originalName : nom original de la série
     * @param string $homepage : lien vers la série
     * @param string $overview : description de la série
     * @param int|null $id : identifiant de la série
     * @param int|null $posterId : identifiant du poster de la série
     * @return TVShow : La sérié crée
     */
    public static function create(
        string $name,
        string $originalName,
        string $homepage,
        string $overview,
        ?int $id = null,
        ?int $posterId = null
    ): TVShow {
        $show = new TVShow();
        $show->setId($id);
        $show->setName($name);
        $show->setOriginalName($originalName);
        $show->setHomepage($homepage);
        $show->setOverview($overview);
        $show->setPosterId($posterId);
        return $show;
    }
}
