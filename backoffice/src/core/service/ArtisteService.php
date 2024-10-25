<?php

namespace nrv\back\core\service;

use Psr\Container\ContainerInterface;
use nrv\back\core\domain\entities\Artiste\Artiste;
use nrv\back\core\domain\entities\Lieu\Lieu;
use nrv\back\core\dto\ArtisteDTO;
use nrv\back\core\repositoryInterfaces\ArtisteRepositoryInterface;

class ArtisteService implements ArtisteServiceInterface{
	protected ArtisteRepositoryInterface $artisteRepository;
	public function __construct(ContainerInterface $co)
	{
		$this->artisteRepository = $co->get(ArtisteRepositoryInterface::class);
	}

    public function getArtistes(): array
    {
		return array_map(function(Artiste $a){
			return new ArtisteDTO($a);
		},$this->artisteRepository->getArtiste());
    }

	

}
