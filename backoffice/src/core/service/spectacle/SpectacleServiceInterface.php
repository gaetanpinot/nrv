<?php

namespace nrv\back\core\service\spectacle;

interface SpectacleServiceInterface
{
    public function getSpectacles(): array;
    public function getSpectaclesByDate($dateDebut, $dateFin): array;

}

