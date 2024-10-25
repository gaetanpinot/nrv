<?php
namespace nrv\back\application\actions;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpInternalServerErrorException;
use nrv\back\application\actions\AbstractAction;
use nrv\back\application\renderer\JsonRenderer;
use nrv\back\core\service\ArtisteServiceInterface;


class GetArtistes extends AbstractAction{
    protected ArtisteServiceInterface $serviceArtiste;
    public function __construct(ContainerInterface $co)
    {
        parent::__construct($co);
        $this->serviceArtiste= $co->get(ArtisteServiceInterface::class);
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try{
            $artistes = $this->serviceArtiste->getArtistes();
            return JsonRenderer::render($rs, 200, $artistes);
        }catch(Exception $e){
           throw new HttpInternalServerErrorException($rq,$e->getMessage()); 
        }
    }

}
