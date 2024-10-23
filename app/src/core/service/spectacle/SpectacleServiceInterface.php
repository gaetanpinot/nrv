<?php

namespace nrv\core\service\spectacle;

interface SpectacleServiceInterface
{
    public function getSpectacles(int $page=0, int $nombre = 10): array;
    public function getSpectaclesByDate($dateDebut, $dateFin): array;

}

