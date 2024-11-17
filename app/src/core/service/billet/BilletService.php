<?php

namespace nrv\core\service\billet;

use nrv\core\domain\entities\Billet\Billet;
use nrv\core\dto\BilletDTO;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;
use nrv\infrastructure\Repositories\BilletRepository;

class BilletService
{
    protected BilletRepositoryInterface $billetRepository;

    public function __construct(BilletRepository $billetRepository)
    {
        $this->billetRepository = $billetRepository;
    }

    public function getBilletsByUserId(string $userId): array
    {
        $billets = $this->billetRepository->getMesBillets($userId);

        return array_map(function($b){
            return new BilletDTO($b);
        },$billets);
    }

    public function getBilletById(string $id_billet): Billet
    {
        $billet = $this->billetRepository->getBilletById($id_billet);
        if (!$billet) {
            throw new \Exception("Billet non trouvé : $id_billet");
        }
        return $billet;
    }
}

