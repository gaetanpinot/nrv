<?php

namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\repositoryInterfaces\BilletPanierRepositoryInterface;
use PDO;

class BilletPanierRepository implements BilletPanierRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function ajouterBilletAuPanier(string $idBillet, string $idPanier): void
    {
        $sql = "INSERT INTO billet_panier (id_billet, id_panier) VALUES (:id_billet, :id_panier)";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':id_billet' => $idBillet,
            ':id_panier' => $idPanier,
        ]);

        if (!$result) {
            throw new \Exception("Impossible d'ajouter la soirée au panier.");
        }
    }

    public function getBilletPanier(string $idBillet, string $idPanier): ?array
    {
        $sql = "SELECT * FROM billet_panier WHERE id_billet = :id_billet AND id_panier = :id_panier";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':id_billet' => $idBillet,
            ':id_panier' => $idPanier,
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }

    public function supprimerBilletDuPanier(string $idBillet, string $idPanier): void
    {
        $sql = "DELETE FROM billet_panier WHERE id_billet = :id_billet AND id_panier = :id_panier";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute([
            ':id_billet' => $idBillet,
            ':id_panier' => $idPanier,
        ]);

        if (!$result) {
            throw new \Exception("Impossible de supprimer la soirée du panier.");
        }
    }
}
