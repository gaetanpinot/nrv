<?php

namespace nrv\core\repositoryInterfaces;

interface BilletPanierRepositoryInterface
{
    public function ajouterBilletAuPanier(string $idBillet, string $idPanier): void;

    public function getBilletPanier(string $idBillet, string $idPanier): ?array;

    public function supprimerBilletDuPanier(string $idBillet, string $idPanier): void;
}
