<?php

namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Panier\Panier;
use nrv\core\repositoryInterfaces\ArtisteRepositoryInterface;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;
use nrv\core\repositoryInterfaces\PanierRepositoryInterface;
use PDO;

class PanierRepository implements PanierRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }
    public function getPanier(): array
    {
        return $this->pdo->query('SELECT * FROM panier')->fetchAll();
    }

    public function getPanierById(string $id): Panier
    {
        $result = $this->pdo->query('SELECT * FROM panier WHERE id = ' . $id)->fetch();
        return new Panier($result['id'], $result['id_utilisateur'], $result['is_valide']);

    }

    public function save(Panier $panier): void
    {
        $request = $this->pdo->prepare('INSERT INTO panier (id, id_utilisateur, is_valide) VALUES (:id, :id_utilisateur, :is_valide) ON CONFLICT (id) DO UPDATE SET id_utilisateur = :id_utilisateur, is_valide = :is_valide');
        $request->execute([
            'id' => $panier->id,
            'id_utilisateur' => $panier->id_utilisateur,
            'is_valide' => $panier->is_valide,
        ]);
    }

    public function updatePanier(Panier $panier): void
    {
        $request = $this->pdo->prepare('UPDATE panier SET id_utilisateur = :id_utilisateur, is_valide = :is_valide WHERE id = :id');
        $request->execute([
            'id' => $panier->id,
            'id_utilisateur' => $panier->id_utilisateur,
            'is_valide' => $panier->is_valide,
        ]);
    }

    public function deletePanier(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM panier WHERE id = :id');
        $request->execute(['id' => $id]);
    }

    public function findByUserIdAndNotValidated(string $id_utilisateur): ?Panier
    {
        $stmt = $this->pdo->prepare('SELECT * FROM panier WHERE id_utilisateur = :id_utilisateur AND is_valide = false');
        $stmt->execute(['id_utilisateur' => $id_utilisateur]);

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }

        return new Panier($result['id'], $result['id_utilisateur'], $result['is_valide']);
    }



}