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
        /* exemple de filtre
        filtre de date : $filtre = array('date' => array('dateDebut' => '1986-06-05', 'dateFin' => '2006-08-02'));
        filtre de lieu : $filtre = array('lieu' => array('id' => '2f925b07-054f-3cf6-875b-ada6cd1ff177'));
        filtre de style : $filtre = array('style' => array('label' => 'Rock'));
        filtre de date et style : $filtre = array('date' => array('dateDebut' => '1986-06-05', 'dateFin' => '2006-08-02'), 
            'style' => array('label' => 'Rock'));
        filtre de style et lieu : $filtre = array('style' => array('label' => 'Rock'), 
            'lieu' => array('id' => '2f925b07-054f-3cf6-875b-ada6cd1ff177'));
        filtre de style, lieu et date : $filtre = array('lieu' => array('id' => 'cc5fab62-8a6d-34f3-b488-d00e32d46369'), 
            'date' => array('dateDebut' => '1966-06-05', 'dateFin' => '2006-08-02'), 'style' => array('label' => 'Rock'));
        */
        $filtre = null;
        $spectacles = $this->spectacleRepository->getSpectacles($page, $nombre, $filtre);
        
        foreach ($spectacles as $spectacle) {
            $res[] = $spectacle->toDTO();
        }
        return $res;
    }
}
