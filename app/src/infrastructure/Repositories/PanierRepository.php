<?php

namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\repositoryInterfaces\ArtisteRepositoryInterface;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;

class ArtisteRepository implements ArtisteRepositoryInterface
{

    public function getArtiste(): array
    {
        return $this->pdo->query('SELECT * FROM artiste')->fetchAll();
    }

    public function getArtisteById(string $id): Artiste
    {
        $result = $this->pdo->query('SELECT * FROM artiste WHERE id = ' . $id)->fetch();
        return new Artiste($result['id'], $result['nom']);

    }

    public function save(Artiste $artiste): void
    {
        $request = $this->pdo->prepare('INSERT INTO artiste (id, nom) VALUES (:id, :nom) ON CONFLICT (id) DO UPDATE SET nom = :nom');
        $request->execute([
            'id' => $artiste->id,
            'nom' => $artiste->nom,
        ]);
    }

    public function updateArtiste(Artiste $artiste): void
    {
        $request = $this->pdo->prepare('UPDATE artiste SET nom = :nom WHERE id = :id');
        $request->execute([
            'id' => $artiste->id,
            'nom' => $artiste->nom,
        ]);
    }

    public function deleteArtiste(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM artiste WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}