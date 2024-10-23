<?php

namespace nrv\back\core\service\panier;

use DI\Container;
use nrv\back\core\dto\PanierDTO;
use nrv\back\infrastructure\Repositories\PanierRepository;
use PDO;
use nrv\back\core\domain\entities\Panier\Panier;

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


}
