<?php
namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Soiree\Soiree;

interface SoireeRepositoryInterface{
    public function getSoirees(): array;
    public function getSoireeById(string $id): Soiree;
    public function save(Soiree $soiree): void;
    public function updateSoiree(Soiree $soiree): void;
    public function deleteSoiree(string $id): void;
public function getSoireeBySpectacleId(string $id): array;
}
