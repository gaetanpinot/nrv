<?php

namespace nrv\back\application\actions;

use DI\Container;
use nrv\back\application\renderer\JsonRenderer;
use nrv\back\core\service\lieu\LieuService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Ramsey\Uuid\Uuid;

class AjouterModifierLieuAction extends AbstractAction
{
    private LieuService $lieuService;

    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->lieuService = $cont->get(LieuService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $lieu = $rq->getParsedBody();

        $this->lieuService->addLieu($lieu);
        return JsonRenderer::render($rs, 200, "Ajouté avec succès");
    }

}