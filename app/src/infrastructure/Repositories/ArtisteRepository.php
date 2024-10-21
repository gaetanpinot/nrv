<?php

namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Billet\Billet;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;

class BilletRepository implements BilletRepositoryInterface
{

    public function getBillet(): array
    {
        return $this->pdo->query('SELECT * FROM billet')->fetchAll();
    }

    public function getBilletById(string $id): Billet
    {
        $result = $this->pdo->query('SELECT * FROM billet WHERE id = ' . $id)->fetch();
        return new Billet($result['id'], $result['id_user'], $result['id_spectacle'], $result['tarif']);

    }

    public function save(Billet $billet): void
    {
        $request = $this->pdo->prepare('INSERT INTO soiree (id, id_user, id_spectacle, tarif) VALUES (:id, :id_user, :id_spectacle, :tarif) ON CONFLICT (id) DO UPDATE SET id_user = :id_user, id_spectacle = :id_spectacle, tarif = :tarif');
        $request->execute([
            'id' => $billet->id,
            'nom' => $billet->id_user,
            'id_theme' => $billet->id_spectacle,
            'date' => $billet->date,
        ]);
    }

    public function updateBillet(Billet $billet): void
    {
        $request = $this->pdo->prepare('UPDATE billet SET id_user = :id_user, id_spectacle = :id_spectacle, tarif = :tarif WHERE id = :id');
        $request->execute([
            'id' => $billet->id,
            'nom' => $billet->id_user,
            'id_theme' => $billet->id_spectacle,
            'date' => $billet->tarif,
        ]);
    }

    public function deleteBillet(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM billet WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}