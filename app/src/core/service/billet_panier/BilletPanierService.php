<?php

namespace nrv\core\service\billet_panier;

use PHPUnit\Exception;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Panier\Panier;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\infrastructure\Repositories\BilletPanierRepository;
use nrv\infrastructure\Repositories\BilletRepository;
use nrv\infrastructure\Repositories\PanierRepository;
use Ramsey\Uuid\Uuid;

class BilletPanierService
{
    protected BilletRepository $billetRepository;
    protected PanierRepository $panierRepository;
    protected BilletPanierRepository $billetPanierRepository;

    public function __construct(
        BilletRepository $billetRepository,
        PanierRepository $panierRepository,
        BilletPanierRepository $billetPanierRepository
    ) {
        $this->billetRepository = $billetRepository;
        $this->panierRepository = $panierRepository;
        $this->billetPanierRepository = $billetPanierRepository;
    }

    public function ajouterBilletAuPanier(string $id_utilisateur, string $id_soiree, float $tarif): void
    {
        $panier = $this->panierRepository->getPanierByIdUtilisateur($id_utilisateur);

        if ($panier == null) {
            $uuid = Uuid::uuid4()->toString();
            $panier = new Panier($uuid, $id_utilisateur, false);
            $this->panierRepository->save($panier);
        }

        $uuid = Uuid::uuid4()->toString();
        $nouveauBillet = new Billet($uuid, $id_utilisateur, new Soiree($id_soiree), $tarif);
        $this->billetRepository->save($nouveauBillet);

        $this->billetPanierRepository->ajouterBilletAuPanier($uuid, $panier->getId());
    }
}
