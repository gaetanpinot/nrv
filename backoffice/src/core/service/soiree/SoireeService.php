<?php

namespace nrv\back\core\service\soiree;

use nrv\back\core\domain\entities\Soiree\Soiree;
use nrv\back\core\dto\SoireeDTO;
use nrv\back\infrastructure\Repositories\SoireeRepository;

class SoireeService implements SoireeServiceInterface
{
    private SoireeRepository $soireeRepository;
    public function __construct(SoireeRepository $soireeRepository)
    {
        $this->soireeRepository = $soireeRepository;
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
                         return array_map(function(Soiree $s){
                                          return new SoireeDTO($s);
        },$soirees);
    }



    public function getJauge():array{
        //Affichage de la jauge des spectacles:nombre de places vendues pour chaque soirée
        $jauge = $this->soireeRepository->getNbPlacesVendues();

        return array_map(function(Soiree $s){
            return $s->toDTO();
        },$jauge);
    }


    public function addSoiree($soiree){
        $this->soireeRepository->save($soiree);
    }
}
