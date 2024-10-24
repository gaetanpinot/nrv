<?php

namespace nrv\application\actions;

use DI\Container;
use nrv\core\service\billet_panier\BilletPanierService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\dto\BilletDTO;

class AjouterBilletDansPanierAction extends AbstractAction
{
    protected BilletPanierService $billetPanierService;

    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->billetPanierService = $cont->get(BilletPanierService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();
        $id_utilisateur = $data['id_utilisateur'];
        $id_soiree = $data['id_soiree'];
        $tarif = 0;

        try {
            $this->billetPanierService->ajouterBilletAuPanier($id_utilisateur, $id_soiree, $tarif);
            $rs->getBody()->write(json_encode(['status' => 'success', 'message' => 'Billet ajouté au panier']));
            return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $rs->getBody()->write(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }
}
