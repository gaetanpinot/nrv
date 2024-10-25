<?php

namespace nrv\back\core\service\soiree;

use nrv\back\core\domain\entities\Lieu\Lieu;
use nrv\back\core\domain\entities\Soiree\Soiree;
use nrv\back\core\dto\SoireeDTO;
use nrv\back\infrastructure\Repositories\SoireeRepository;
use Ramsey\Uuid\Uuid;

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


    public function addSoiree($soiree_data){
        $lieu = new Lieu($soiree_data['lieu_id'], null, null, null, null, null);

        $soiree = new Soiree(Uuid::uuid4()->toString(), $soiree_data['nom'],$soiree_data['id_theme'], $soiree_data['date'], $soiree_data['heure_debut'], $soiree_data['duree'], $lieu, array(), $soiree_data['nb_places_assises_restantes'], $soiree_data['nb_places_debout_restantes'], $soiree_data['tarif_normal'], $soiree_data['tarif_reduit']);
        $this->soireeRepository->save($soiree, $soiree_data['spectacles']);
    }
}
