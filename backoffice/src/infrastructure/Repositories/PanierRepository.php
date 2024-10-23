<?php

namespace nrv\back\infrastructure\Repositories;

use DI\Container;
use nrv\back\core\domain\entities\Artiste\Artiste;
use nrv\back\core\domain\entities\Billet\Billet;
use nrv\back\core\domain\entities\Panier\Panier;
use nrv\back\core\repositoryInterfaces\ArtisteRepositoryInterface;
use nrv\back\core\repositoryInterfaces\BilletRepositoryInterface;
use nrv\back\core\repositoryInterfaces\PanierRepositoryInterface;
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
}