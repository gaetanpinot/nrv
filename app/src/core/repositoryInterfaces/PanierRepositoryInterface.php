<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Panier\Panier;

interface PanierRepositoryInterface
{
    public function getPanier(): array;
    public function getPanierById(string $id): ?Panier;
    public function save(Panier $panier): void;
    public function updatePanier(Panier $panier): void;
    public function deletePanier(string $id): void;
}