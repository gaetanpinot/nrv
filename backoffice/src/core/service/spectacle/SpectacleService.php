<?php

namespace nrv\back\core\service\spectacle;


use DI\Container;
use Ramsey\Uuid\Uuid;
use nrv\back\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\back\infrastructure\Repositories\SpectacleRepository;
use nrv\back\core\domain\entities\Spectacle\Spectacle;
use Psr\Container\ContainerInterface;

class SpectacleService implements SpectacleServiceInterface
{
    private SpectacleRepositoryInterface $spectacleRepository;

    public function __construct(ContainerInterface $cont) {
        $this->spectacleRepository = $cont->get(SpectacleRepositoryInterface::class);
    }   

    public function getSpectacles(): array
    {
        $res = array();
        $spectacles = $this->spectacleRepository->getSpectacles();
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

    public function addSpectacle($spectacle_data){
        $spectacle = new Spectacle(Uuid::uuid4()->toString(), $spectacle_data['titre'], $spectacle_data['description'], $spectacle_data['url_video'], $spectacle_data['url_image'], $spectacle_data['artistes']);
        $this->spectacleRepository->save($spectacle);
    }

}
