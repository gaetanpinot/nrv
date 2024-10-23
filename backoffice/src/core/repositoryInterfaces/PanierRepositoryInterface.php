<?php

namespace nrv\back\core\repositoryInterfaces;

use nrv\back\core\domain\entities\Artiste\Artiste;
use nrv\back\core\domain\entities\Billet\Billet;
use nrv\back\core\domain\entities\Panier\Panier;

interface PanierRepositoryInterface
{
    public function getPanier(): array;
    public function getPanierById(string $id): Panier;
    public function save(Panier $panier): void;
    public function updatePanier(Panier $panier): void;
    public function deletePanier(string $id): void;
}