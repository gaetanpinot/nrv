<?php
namespace nrv\core\service\soiree;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\dto\SoireeDTO;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use nrv\infrastructure\Repositories\SoireeRepository;

class SoireeService implements SoireeServiceInterface
{
    private SoireeRepositoryInterface $soireeRepository;
    protected LoggerInterface $log;
    public function __construct(ContainerInterface $co)
    {
        $this->soireeRepository = $co->get(SoireeRepositoryInterface::class);
        $this->log = $co->get(LoggerInterface::class);
    }

    public function getSoireeDetail($soiree_id): SoireeDTO
    {
        //Affichage du détail d’une soirée : nom de la soirée, thématique, date et horaire, lieu, tarifs,
        //ainsi que la liste des spectacles : titre, artistes, description, style de musique, vidéo

        $soiree = $this->soireeRepository->getSoireeById($soiree_id);
        return $soiree->toDTO();
    }

    public function getSoireeSpectacleId(string $id): array
    {
        $soirees = $this->soireeRepository->getSoireeBySpectacleId($id);
        
        $this->log->error(count($soirees));
        return array_map(function(Soiree $s){
            return new SoireeDTO($s);
        },$soirees);
    }

}
