<?php

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;

class Poster
{
    private int $id;
    private string $jpeg;

    public function getId(): int
    {
        return $this->id;
    }

    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**
     * Méthode de classe qui renvoie et crée une instance d'un Poster avec son id et son jpeg
     * @param $id : Identifiant du poster
     * @throws EntityNotFoundException
     */
    public static function findById(int $id): Poster
    {
        $requete = MyPdo::getInstance()->prepare(
            <<<'SQL'
                SELECT *
                FROM poster
                WHERE id = :id
            SQL
        );
        $requete->execute([":id" => $id]);
        $resultat = $requete->fetchObject(Poster::class);
        if ($resultat == null) {
            throw new EntityNotFoundException("Poster - Le poster (id: {$id}) n'existe pas");
        }
        return $resultat;
    }
}
