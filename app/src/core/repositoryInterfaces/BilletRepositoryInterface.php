<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Billet\Billet;

interface BilletRepositoryInterface
{
    public function getBillet(): array;
    public function getBilletById(string $id): Billet;
    public function save(Billet $billet): void;
    public function updateBillet(Billet $billet): void;
    public function deleteBillet(string $id): void;
}