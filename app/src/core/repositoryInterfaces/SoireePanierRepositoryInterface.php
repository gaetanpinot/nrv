<?php

namespace nrv\core\repositoryInterfaces;

interface SoireePanierRepositoryInterface
{
    /**
     * Ajoute une soirée au panier.
     *
     * @param string $idSoiree
     * @param string $idPanier
     * @return void
     */
    public function ajouterSoireeAuPanier(string $idSoiree, string $idPanier): void;

    /**
     * Récupère une entrée dans le panier par idSoiree et idPanier.
     *
     * @param string $idSoiree
     * @param string $idPanier
     * @return array|null
     */
    public function getSoireePanier(string $idSoiree, string $idPanier): ?array;

    /**
     * Supprime une soirée du panier.
     *
     * @param string $idSoiree
     * @param string $idPanier
     * @return void
     */
    public function supprimerSoireeDuPanier(string $idSoiree, string $idPanier): void;
}
