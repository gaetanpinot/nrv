<?php

namespace nrv\core\service\panier;

use DI\Container;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\dto\BilletDTO;
use nrv\core\dto\PanierDTO;
use nrv\infrastructure\Repositories\PanierRepository;
use PDO;
use nrv\core\domain\entities\Panier\Panier;

class PanierService
{
    protected PanierRepository $panierRepository;
    protected PDO $pdo;

    public function __construct(PanierRepository $panierRepository, Container $cont)
    {
        $this->panierRepository = $panierRepository;
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getPanierById(string $userId): array
    {
        $billets = $this->panierRepository->getPanierBillets();
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
