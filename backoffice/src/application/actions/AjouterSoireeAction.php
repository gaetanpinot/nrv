<?php

namespace nrv\back\application\actions;

use DI\Container;
use nrv\back\application\renderer\JsonRenderer;
use nrv\back\core\service\soiree\SoireeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AjouterSoireeAction extends AbstractAction
{
    private SoireeService $soireeService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->soireeService = $container->get(SoireeService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $soiree = $rq->getParsedBody();
        $this->soireeService->addSoiree($soiree);
        return JsonRenderer::render($rs, 200, "Ajouté avec succès");
    }
}