<?php

namespace nrv\infrastructure\Repositories;

use nrv\core\repositoryInterfaces\SoireePanierRepositoryInterface;
use PDO;

class SoireePanierRepository implements SoireePanierRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function ajouterSoireeAuPanier(string $idSoiree, string $idPanier): void
    {
        $sql = "INSERT INTO soiree_panier (id_soiree, id_panier) VALUES (:id_soiree, :id_panier)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':id_soiree' => $idSoiree,
            ':id_panier' => $idPanier,
        ]);

        if (!$result) {
            throw new \Exception("Impossible d'ajouter la soirée au panier.");
        }
    }

    public function getSoireePanier(string $idSoiree, string $idPanier): ?array
    {
        $sql = "SELECT * FROM soiree_panier WHERE id_soiree = :id_soiree AND id_panier = :id_panier";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_soiree' => $idSoiree,
            ':id_panier' => $idPanier,
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function supprimerSoireeDuPanier(string $idSoiree, string $idPanier): void
    {
        $sql = "DELETE FROM soiree_panier WHERE id_soiree = :id_soiree AND id_panier = :id_panier";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':id_soiree' => $idSoiree,
            ':id_panier' => $idPanier,
        ]);

        if (!$result) {
            throw new \Exception("Impossible de supprimer la soirée du panier.");
        }
    }
}
