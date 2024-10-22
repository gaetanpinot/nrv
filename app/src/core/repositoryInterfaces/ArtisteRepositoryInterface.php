<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Billet\Billet;

interface ArtisteRepositoryInterface
{
    public function getArtiste(): array;
    public function getArtisteById(string $id): Artiste;
    public function save(Artiste $artiste): void;
    public function updateArtiste(Artiste $artiste): void;
    public function deleteArtiste(string $id): void;
}