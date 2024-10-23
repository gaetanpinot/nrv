<?php

namespace nrv\core\service\panier;

use DI\Container;
use nrv\core\domain\entities\Billet\Billet;
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

    public function getPanierById(string $id): PanierDTO
    {
        $request = $this->pdo->prepare('SELECT * FROM panier WHERE id_utilisateur = :id_utilisateur');
        $request->execute(['id_utilisateur' => $id]);
        $result = $request->fetch();

        if (!$result) {
            throw new \Exception("Panier non trouvé pour l'id: $id");
        }

        return new PanierDTO(new Panier ($result['id'], $result['id_utilisateur'], $result['is_valide']));
    }

    public function addBilletToPanier(string $id_utilisateur, Billet $billet): void
    {
        $panier = $this->getOrCreatePanierForUser($id_utilisateur);

        $panier->setIdBillet($billet->getId());

        $this->panierRepository->save($panier);
    }

    public function getOrCreatePanierForUser(string $id_utilisateur): Panier
    {
        try {
            return $this->panierRepository->getPanierByUserId($id_utilisateur);
        } catch (\Exception $e) {
            return new Panier(uniqid(), $id_utilisateur, null, false);
        }
    }


}
