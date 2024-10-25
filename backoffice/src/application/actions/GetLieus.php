<?php

namespace nrv\back\application\actions;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use nrv\back\application\actions\AbstractAction;
use nrv\back\application\renderer\JsonRenderer ;
use nrv\back\core\service\lieu\LieuServiceInterface;

class GetLieus extends AbstractAction{
    protected LieuServiceInterface $serviceLieu;
    public function __construct(ContainerInterface $co)
    {
        $this->serviceLieu=$co->get(LieuServiceInterface::class);
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $lieus = $this->serviceLieu->getLieus();
            return JsonRenderer::render($rs,200,$lieus);
        }catch(Exception $e){
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
    }

}
