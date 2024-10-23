<?php
namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Spectacle\Spectacle;

interface SpectacleRepositoryInterface{

    public function getSpectacles(int $page =0, int $nombre =10, array $filtre = null): array;
    public function getSpectacleById(string $id): Spectacle;
    public function save(Spectacle $spectacle): void;
    public function updateSpectacle(Spectacle $spectacle): void;
    public function deleteSpectacle(string $id): void;
}
