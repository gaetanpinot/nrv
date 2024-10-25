<?php

namespace nrv\core\service\billet;

use nrv\core\domain\entities\Billet\Billet;
use nrv\core\dto\BilletDTO;
use nrv\infrastructure\Repositories\BilletRepository;

class BilletService
{
    protected BilletRepository $billetRepository;

    public function __construct(BilletRepository $billetRepository)
    {
        $this->billetRepository = $billetRepository;
    }

    public function getBilletsByUserId(string $userId): array
    {
        $billets = $this->billetRepository->getMesBillets();
        $userBillets = [];

        foreach ($billets as $billet) {
            if ($billet['id_utilisateur'] === $userId) {
                $userBillets[] = new BilletDTO(new Billet(
                    $billet['id'],
                    $billet['id_utilisateur'],
                    $billet['id_soiree'],
                    $billet['tarif']
                ));
            }
        }

        return $userBillets;
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

