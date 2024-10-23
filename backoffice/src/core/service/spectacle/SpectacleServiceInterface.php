<?php

namespace nrv\core\service\spectacle;

interface SpectacleServiceInterface
{
    public function getSpectacles(): array;
    public function getSpectaclesByDate($dateDebut, $dateFin): array;

}

