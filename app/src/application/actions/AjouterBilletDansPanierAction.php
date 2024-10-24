<?php

namespace nrv\application\actions;

use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use nrv\core\service\billet\BilletService;
use nrv\core\service\panier\PanierService;
use Psr\Http\Message\ResponseFactoryInterface;

class AjouterBilletDansPanierAction extends AbstractAction
{
    protected BilletService $billetService;
    protected PanierService $panierService;

    public function __construct(Container $cont, BilletService $billetService, PanierService $panierService)
    {
        parent::__construct($cont);
        $this->billetService = $billetService;
        $this->panierService = $panierService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();
        $id_utilisateur = $data['id_utilisateur'] ?? null;
        $id_billet = $data['id_billet'] ?? null;

        if (!$id_utilisateur || !$id_billet) {
            $rs->getBody()->write(json_encode(['error']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $billet = $this->billetService->getBilletById($id_billet);

            $this->panierService->addBilletToPanier($id_utilisateur, $billet);

            $rs->getBody()->write(json_encode(['success' => 'Billet ajouter au panier']));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $this->loger->error($e->getMessage());
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
