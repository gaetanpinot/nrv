<?php

namespace nrv\core\service\spectacle;


use DI\Container;
use Psr\Log\LoggerInterface;
use nrv\core\dto\SpectacleDTO;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use nrv\infrastructure\Repositories\SpectacleRepository;
use Psr\Container\ContainerInterface;

class SpectacleService implements SpectacleServiceInterface
{
    private SpectacleRepositoryInterface $spectacleRepository;

    protected LoggerInterface $log;
    public function __construct(ContainerInterface $cont) {
        $this->spectacleRepository = $cont->get(SpectacleRepositoryInterface::class);
        $this->log = $cont->get(LoggerInterface::class)->withName("SpectacleService");
    }   

    public function getSpectacles(int $page=0, int $nombre=12, array $filtre = null): array
    {
        try{
        $res = array();
        $spectacles = $this->spectacleRepository->getSpectacles($page, $nombre, $filtre);
        foreach ($spectacles as $spectacle) {
            $res[] = new SpectacleDTO($spectacle);

        }
            $this->log->info(gettype($res));
        return $res;
        }catch(\Error $e){
        $this->log->error($e->getMessage());
        }
    }
}
