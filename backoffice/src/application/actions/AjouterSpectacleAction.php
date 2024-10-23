<?php

namespace nrv\application\actions;

use DI\Container;
use nrv\application\renderer\JsonRenderer;
use nrv\core\service\spectacle\SpectacleService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AjouterSpectacleAction extends AbstractAction
{
    private SpectacleService $spectacleService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->spectacleService = $container->get(SpectacleService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $spectacle_params = $rq->getQueryParams();
        $this->spectacleService->addSpectacle($spectacle_params);
        return JsonRenderer::render($rs, 200, "Ajouté avec succès");
    }
}