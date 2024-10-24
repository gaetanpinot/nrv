<?php
namespace nrv\application\actions;

use DI\Container;
use nrv\core\service\lieu\LieuService;
use nrv\core\service\lieu\LieuServiceInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use nrv\application\renderer\JsonRenderer;

class GetLieuxAction extends AbstractAction{

    private LieuServiceInterface $lieuService;
    public function __construct(Container $cont){
        parent::__construct($cont);
        $this->lieuService = $cont->get(LieuService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $lieux = $this->lieuService->getLieux();
        return JsonRenderer::render($rs, 200, $lieux);
    }
}