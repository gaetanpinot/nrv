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
        return new Artiste($result['id'], $result['prenom']);

    }

    public function save(Artiste $artiste): void
    {
        $request = $this->pdo->prepare('INSERT INTO artiste (id, prenom) VALUES (:id, :prenom) ON CONFLICT (id) DO UPDATE SET nom = :prenom');
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