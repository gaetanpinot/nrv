<?php

namespace nrv\back\application\actions;

use DI\Container;
use PHPUnit\Exception;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpInternalServerErrorException;
use nrv\back\application\renderer\JsonRenderer;
use nrv\back\core\service\spectacle\SpectacleServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetSpectacles extends AbstractAction
{
    private SpectacleServiceInterface $spectacleService;
    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->spectacleService = $cont->get(SpectacleServiceInterface::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        //Affichage de la liste des spectacles : pour chaque spectacle, on affiche le titre, la date et
        //l’horaire, une image.
        try{
        $spectacles = $this->spectacleService->getSpectacles();
        }catch(Exception $e){
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
        return JsonRenderer::render($rs, 200, $spectacles);
    }
}
