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

    public function getPanierByUserId(string $userId): array
    {
        $billets = $this->panierRepository->getPanierBilletsByUserId($userId);

        return array_map(function($b){
            return new BilletDTO($b);
        }, $billets);
    }

}
