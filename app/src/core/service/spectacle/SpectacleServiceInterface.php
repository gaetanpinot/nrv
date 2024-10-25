<?php

namespace nrv\core\service\spectacle;

interface SpectacleServiceInterface
{
    public function getSpectacles(int $page=0, int $nombre = 12, array $filtre = null): array;

}

