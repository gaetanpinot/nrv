<?php

namespace nrv\application\actions;

use DI\Container;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
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
        //Affichage de la liste des spectacles : pour chaque spectacle, on affiche le titre, la date et
        //l’horaire, une image.
        $params = $rq->getQueryParams();
        $pageValidator = Validator::key('page',Validator::intVal()->greaterThan(-1));
        $nombreValidator = Validator::key('nombre',Validator::intVal()->greaterThan(0)->lessThan(31));
        $page = 0;
        $nombre = 12;
        $filtre = array();
        
        if(isset($params['style'])){
            $style = $params['style'];
            $filtre = array('style' => array('label' => $style));
        }
        if(isset($params['lieu'])){
            $lieu = $params['lieu'];
            $filtre = array_merge($filtre ,array('lieu' => array('nom' => $lieu)));
        }
        if(isset($params['date'])){
            $sens = $params['date'];
            $filtre = array_merge($filtre ,array('date' => array('sens' => $sens)));
        }
        try{
            $pageValidator->assert($params);
            $page = $params['page'];
            $nombreValidator->assert($params);
            $nombre = $params['nombre'];
        }catch(NestedValidationException $e){
        }
        $spectacles = $this->spectacleService->getSpectacles($page, $nombre, $filtre);
        return JsonRenderer::render($rs, 200, $spectacles);
    }
}
