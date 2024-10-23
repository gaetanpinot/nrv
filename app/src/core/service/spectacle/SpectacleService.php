<?php

namespace nrv\core\service\spectacle;


use DI\Container;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\infrastructure\Repositories\SpectacleRepository;
use Psr\Container\ContainerInterface;

class SpectacleService implements SpectacleServiceInterface
{
    private SpectacleRepositoryInterface $spectacleRepository;

    public function __construct(ContainerInterface $cont) {
        $this->spectacleRepository = $cont->get(SpectacleRepositoryInterface::class);
    }   

    public function getSpectacles(int $page=0, int $nombre=10): array
    {
        $res = array();
        $spectacles = $this->spectacleRepository->getSpectacles($page,$nombre);
        foreach ($spectacles as $spectacle) {
            $res[] = $spectacle->toDTO();
        }
        return $res;
    }

    public function getSpectaclesByDate($dateDebut, $dateFin): array{
        $res = array();
        $spectacles = $this->spectacleRepository->getSpectaclesByDate($dateDebut, $dateFin);
        foreach ($spectacles as $spectacle) {
            $res[] = $spectacle->toDTO();
        }
        return $res;
    }
}
