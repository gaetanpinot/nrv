<?php

namespace nrv\application\actions;

use DI\Container;
use nrv\application\renderer\JsonRenderer;
use nrv\core\service\spectacle\SpectacleService;
use nrv\core\service\spectacle\SpectacleServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AfficheListeSpectaclesAction extends AbstractAction
{
    private SpectacleServiceInterface $spectacleService;
    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->spectacleService = $cont->get(SpectacleServiceInterface::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $spectacles = $this->spectacleService->getSpectacles();
        return JsonRenderer::render($rs, 200, $spectacles);
    }
}
