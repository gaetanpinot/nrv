<?php
namespace nrv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\core\service\billet\BilletService;
use DI\Container;

class GetUserBilletsAction extends AbstractAction
{
    protected BilletService $billetService;

    public function __construct(Container $cont, BilletService $billetService)
    {
        parent::__construct($cont);
        $this->billetService = $billetService;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $userId = $args['id'];

        try {
            $billets = $this->billetService->getBilletsByUserId($userId);
            $rs->getBody()->write(json_encode($billets));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $this->loger->error("Erreur lors de la récupération des billets de l'utilisateur $userId : " . $e->getMessage());
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
