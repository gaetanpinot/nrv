<?php
namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Lieu\Lieu;
use nrv\core\domain\entities\Soiree\Soiree;

interface LieuRepositoryInterface{
    public function getLieux(): array;
    public function getLieuById(string $id): Lieu;
    public function getLieuBySoiree(Soiree $soiree): Lieu;
    public function save(Lieu $lieu): void;
    public function updateLieu(Lieu $lieu): void;
    public function deleteLieu(string $id): void;
}