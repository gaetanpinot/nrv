<?php

namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;
use PDO;

class BilletRepository implements BilletRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(Container $cont)
    {
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getBillet(): array
    {
        return $this->pdo->query('SELECT * FROM billet')->fetchAll();
    }

    public function getBilletById(string $id): Billet
    {
        $result = $this->pdo->query('SELECT * FROM billet WHERE id = :id');
        $result->execute(['id' => $id]);
        $result = $result->fetch();
        return new Billet($result['id'], $result['id_utilisateur'], $result['id_soiree'], $result['tarif']);

    }

    public function save(Billet $billet): void
    {
        $request = $this->pdo->prepare('INSERT INTO billet (id, id_user, id_soiree, tarif) VALUES (:id, :id_utilisateur, :id_soiree, :tarif) ON CONFLICT (id) DO UPDATE SET id_user = :id_utilisateur, id_soiree = :id_soiree, tarif = :tarif');
        $request->execute([
            'id' => $billet->id,
            'id_utilisateur' => $billet->id_user,
            'id_soiree' => $billet->id_spectacle,
            'tarif' => $billet->tarif,
        ]);
    }

    public function updateBillet(Billet $billet): void
    {
        $request = $this->pdo->prepare('UPDATE billet SET id_user = :id_utilisateur, id_spectacle = :id_soiree, tarif = :tarif WHERE id = :id');
        $request->execute([
            'id' => $billet->id,
            'id_utilisateur' => $billet->id_user,
            'id_soiree' => $billet->id_spectacle,
            'tarif' => $billet->tarif,
        ]);
    }

    public function deleteBillet(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM billet WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}