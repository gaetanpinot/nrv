<?php
namespace nrv\core\service\lieu;

use nrv\core\dto\LieuDTO;

interface LieuServiceInterface{
    public function getLieux(): array;
    public function getLieuById(string $id_lieu): LieuDTO;
}