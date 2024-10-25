<?php
namespace nrv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\core\service\billet\BilletService;
use DI\Container;
use nrv\application\renderer\JsonRenderer;

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
            return JsonRenderer::render($rs, 200, $billets);
        } catch (\Exception $e) {
            $this->loger->error("Erreur lors de la récupération des billets de l'utilisateur $userId : " . $e->getMessage());
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
    }
}
