<?php

namespace nrv\back\application\actions;

use DI\Container;
use nrv\back\application\renderer\JsonRenderer;
use nrv\back\core\service\soiree\SoireeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AfficherJaugeSpectacleAction extends AbstractAction
{
    private SoireeService $soireeService;

    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->soireeService = $cont->get(SoireeService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $jauge = $this->soireeService->getJauge();
        return JsonRenderer::render($rs, 200, $jauge);

    }
}