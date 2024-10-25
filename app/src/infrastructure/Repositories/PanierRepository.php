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
use Ramsey\Uuid\Uuid;

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

    public function getPanierById(string $id): ?Panier
    {
        $stmt = $this->pdo->prepare('SELECT * FROM panier WHERE id = :id');

        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }
        return new Panier($result['id'], $result['id_utilisateur'], $result['is_valide']);

    }

    public function save(Panier $panier): void
    {
        $request = $this->pdo->prepare('
        INSERT INTO panier (id, id_utilisateur, is_valide) 
        VALUES (:id, :id_utilisateur, :is_valide) 
        ON CONFLICT (id) DO UPDATE 
        SET id_utilisateur = :id_utilisateur, is_valide = :is_valide
                            
    ');
        $isValide = "0";
        $request->execute([
            'id' => $panier->id,
            'id_utilisateur' => $panier->id_utilisateur,
            'is_valide' => $isValide,
        ]);
        $request->fetch();

        $request->fetch();
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

    public function getPanierByIdUtilisateur(string $id_utilisateur): ?Panier
    {
        $stmt = $this->pdo->prepare('SELECT * FROM panier WHERE id_utilisateur = :id_utilisateur');

        $stmt->execute(['id_utilisateur' => $id_utilisateur]);

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }
        return new Panier($result['id'], $result['id_utilisateur'], $result['is_valide']);

    }

    public function getPanierBillets(): array
    {
        $query = '
        SELECT billet.* 
        FROM billet
        INNER JOIN billet_panier ON billet.id = billet_panier.id_billet
        INNER JOIN panier ON panier.id = billet_panier.id_panier
        WHERE panier.is_valide = false
    ';

        return $this->pdo->query($query)->fetchAll();
    }



}