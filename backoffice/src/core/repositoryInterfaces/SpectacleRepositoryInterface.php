<?php
namespace nrv\back\core\repositoryInterfaces;

use nrv\back\core\domain\entities\Spectacle\Spectacle;

interface SpectacleRepositoryInterface{
    public function getSpectacles(): array;
    public function getSpectaclesByDate($dateDebut, $dateFin): array;
    public function getSpectacleById(string $id): Spectacle;
    public function save(Spectacle $spectacle): void;
    public function updateSpectacle(Spectacle $spectacle): void;
    public function deleteSpectacle(string $id): void;
}