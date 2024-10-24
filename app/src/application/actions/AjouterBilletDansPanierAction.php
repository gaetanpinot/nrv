<?php

namespace nrv\application\actions;

use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\core\service\panier\PanierService;
use nrv\core\domain\entities\Billet\Billet;

class AjouterBilletDansPanierAction extends AbstractAction
{
    protected PanierService $panierService;

    public function __construct(Container $cont, PanierService $panierService)
    {
        parent::__construct($cont);
        $this->panierService = $panierService;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $data = $rq->getParsedBody();

        $id_panier = $args['id_panier'];
        $id_billet = $data['id_billet'] ?? null;
        $id_user = $data['id_user'] ?? null;
        $id_spectacle = $data['id_spectacle'] ?? null;
        $tarif = $data['tarif'] ?? null;

        if (!$id_billet || !$id_user || !$id_spectacle || !$tarif) {
            $rs->getBody()->write(json_encode(['error' => 'Toute les informations ne sont pas transmise.']));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        $billet = new Billet($id_billet, $id_user, $id_spectacle, $tarif);

        try {
            $panierDTO = $this->panierService->ajouterBilletDansPanier($id_panier, $billet);
            $rs->getBody()->write(json_encode($panierDTO));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}


