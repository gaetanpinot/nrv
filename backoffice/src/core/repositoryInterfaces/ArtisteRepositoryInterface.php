<?php

namespace nrv\back\core\repositoryInterfaces;

use nrv\back\core\domain\entities\Artiste\Artiste;
use nrv\back\core\domain\entities\Billet\Billet;

interface ArtisteRepositoryInterface
{
    public function getArtiste(): array;
    public function getArtisteById(string $id): Artiste;
    public function save(Artiste $artiste): void;
    public function updateArtiste(Artiste $artiste): void;
    public function deleteArtiste(string $id): void;
}