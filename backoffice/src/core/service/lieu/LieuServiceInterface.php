<?php

namespace nrv\back\core\service\lieu;

interface LieuServiceInterface
{
    public function addLieu($lieu): void;
    public function deleteLieu($lieu_id): void;
    public function modifierLieu($lieu): void;

}