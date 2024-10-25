<?php

namespace nrv\application\actions;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\core\service\panier\PanierService;
use nrv\application\renderer\JsonRenderer;

class GetPanierByIdAction
{
    protected PanierService $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        try {
            $panier = $this->panierService->getPanierById($id);
            return JsonRenderer::render($response, 200, $panier);
        } catch (\Exception $e) {
            return JsonRenderer::render($response, 500, ['error' => $e->getMessage()]);
        }
    }
}
