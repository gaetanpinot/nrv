<?php

namespace nrv\core\service\billet_panier;

use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Panier\Panier;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;
use nrv\core\repositoryInterfaces\PanierRepositoryInterface;
use nrv\core\repositoryInterfaces\SoireePanierRepositoryInterface;
use nrv\infrastructure\Repositories\BilletRepository;
use nrv\infrastructure\Repositories\PanierRepository;
use nrv\infrastructure\Repositories\SoireePanierRepository;

class BilletPanierService
{
    protected BilletRepository $billetRepository;
    protected PanierRepository $panierRepository;
    protected SoireePanierRepository $soireePanierRepository;

    public function __construct(
        BilletRepository $billetRepository,
        PanierRepository $panierRepository,
        SoireePanierRepository $soireePanierRepository
    ) {
        $this->billetRepository = $billetRepository;
        $this->panierRepository = $panierRepository;
        $this->soireePanierRepository = $soireePanierRepository;
    }

    public function ajouterBilletAuPanier(string $id_utilisateur, string $id_soiree, float $tarif): void
    {
        // Vérification si un panier existe pour cet utilisateur
        $panier = $this->panierRepository->findByUserIdAndNotValidated($id_utilisateur);

        if (!$panier) {
            // Si pas de panier, on le crée
            $panier = new Panier(uniqid(), $id_utilisateur, false);
            $this->panierRepository->save($panier);
        }

        // Vérification si l'utilisateur a déjà un billet pour cette soirée
        $billet = $this->billetRepository->findByUserIdAndSoiree($id_utilisateur, $id_soiree);

        if ($billet) {
            throw new \Exception("Vous avez déjà un billet pour cette soirée.");
        }

        // Création d'un nouveau billet
        $nouveauBillet = new Billet(uniqid(), $id_utilisateur, $id_soiree, $tarif);
        $this->billetRepository->save($nouveauBillet);

        // Liaison entre la soirée et le panier
        $this->soireePanierRepository->addSoireeToPanier($id_soiree, $panier->getId());
    }
}
