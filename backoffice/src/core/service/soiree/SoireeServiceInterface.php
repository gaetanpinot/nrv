<?php

namespace nrv\back\core\service\soiree;

use nrv\back\core\dto\SoireeDTO;

interface SoireeServiceInterface
{
    public function getSoireeDetail($soiree_id): SoireeDTO;
}