<?php

namespace nrv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\core\service\billet\BilletService;

class GetUserBilletsAction
{
    protected BilletService $billetService;

    public function __construct(BilletService $billetService)
    {
        $this->billetService = $billetService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $userId = $args['id'];

        try {
            $billets = $this->billetService->getBilletsByUserId($userId);

            $response->getBody()->write(json_encode($billets));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
