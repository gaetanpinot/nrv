<?php

namespace nrv\back\core\service\lieu;

use DI\Container;
use nrv\back\infrastructure\Repositories\LieuRepository;
use nrv\back\core\domain\entities\Lieu\Lieu;
use Ramsey\Uuid\Uuid;


class LieuService implements LieuServiceInterface
{
    private LieuRepository $lieuRepository;

    public function __construct(Container $container)
    {
        $this->lieuRepository = $container->get(LieuRepository::class);
    }

    public function addLieu($lieu): void
    {
        if(!isset($lieu['id'])){
            $lieu['id'] = Uuid::uuid4()->toString();
        }
        $lieuRes = new Lieu($lieu['id'], $lieu['nom'], $lieu['adresse'], $lieu['nb_places_assises'], $lieu['nb_places_debout'], $lieu['lien_image']);

        $this->lieuRepository->save($lieuRes);
    }

    public function deleteLieu($lieu_id): void
    {
        $this->lieuRepository->deleteLieu($lieu_id);
    }

    public function modifierLieu($lieu): void
    {
        $this->lieuRepository->updateLieu($lieu);
    }
}