<?php

namespace nrv\back\infrastructure\Repositories;

use DI\Container;
use nrv\back\core\domain\entities\Artiste\Artiste;
use nrv\back\core\repositoryInterfaces\ArtisteRepositoryInterface;
use PDO;

class ArtisteRepository implements ArtisteRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(Container $cont)
    {
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getArtiste(): array
    {
        return array_map(function($art){
            return new Artiste($art['id'],$art['prenom']);
        },$this->pdo->query('SELECT * FROM artiste')->fetchAll());
    }

    public function getArtisteById(string $id): Artiste
    {
        $result = $this->pdo->query('SELECT * FROM artiste WHERE id = :id');
        $result->execute(['id' => $id]);
        $result = $result->fetch();
        return new Artiste($result['id'], $result['prenom']);

    }

    public function save(Artiste $artiste): void
    {
        $request = $this->pdo->prepare('INSERT INTO artiste (id, prenom) VALUES (:id, :prenom) ON CONFLICT (id) DO UPDATE SET prenom = :prenom');
        $request->execute([
            'id' => $artiste->id,
            'prenom' => $artiste->prenom,
        ]);
    }

    public function updateArtiste(Artiste $artiste): void
    {
        $request = $this->pdo->prepare('UPDATE artiste SET prenom = :prenom WHERE id = :id');
        $request->execute([
            'id' => $artiste->id,
            'prenom' => $artiste->prenom,
        ]);
    }

    public function deleteArtiste(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM artiste WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}