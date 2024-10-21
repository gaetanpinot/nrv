<?php

namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Panier\Panier;
use nrv\core\repositoryInterfaces\ArtisteRepositoryInterface;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;
use nrv\core\repositoryInterfaces\PanierRepositoryInterface;

class PanierRepository implements PanierRepositoryInterface
{

    public function getPanier(): array
    {
        return $this->pdo->query('SELECT * FROM panier')->fetchAll();
    }

    public function getPanierById(string $id): Panier
    {
        $result = $this->pdo->query('SELECT * FROM panier WHERE id = ' . $id)->fetch();
        return new Panier($result['id'], $result['$email_utilisateur'], $result['is_valide']);

    }

    public function save(Panier $panier): void
    {
        $request = $this->pdo->prepare('INSERT INTO panier (id, email_utilisateur, is_valide) VALUES (:id, :email_utilisateur, :is_valide) ON CONFLICT (id) DO UPDATE SET email_utilisateur = :email_utilisateur, is_valide = :is_valide');
        $request->execute([
            'id' => $panier->id,
            'email_utilisateur' => $panier->email_utilisateur,
            'is_valide' => $panier->is_valide,
        ]);
    }

    public function updatePanier(Panier $panier): void
    {
        $request = $this->pdo->prepare('UPDATE panier SET email_utilisateur = :email_utilisateur, is_valide = :is_valide WHERE id = :id');
        $request->execute([
            'id' => $panier->id,
            'email_utilisateur' => $panier->email_utilisateur,
            'is_valide' => $panier->is_valide,
        ]);
    }

    public function deletePanier(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM panier WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}