<?php

namespace nrv\back\core\service\billet;

use nrv\back\core\domain\entities\Billet\Billet;
use nrv\back\core\dto\BilletDTO;
use nrv\back\infrastructure\Repositories\BilletRepository;

class BilletService
{
    protected BilletRepository $billetRepository;

    public function __construct(BilletRepository $billetRepository)
    {
        $this->billetRepository = $billetRepository;
    }

    public function getBilletsByUserId(string $userId): array
    {
        $billets = $this->billetRepository->getBillet();
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
}
