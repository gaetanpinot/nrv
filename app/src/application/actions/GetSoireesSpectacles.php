<?php
namespace nrv\application\actions;

use DI\Container;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use nrv\application\renderer\JsonRenderer;
use nrv\application\actions\AbstractAction;
use nrv\core\service\soiree\SoireeService;

class GetSoireesSpectacles extends AbstractAction{
    
    private SoireeService $soireeService;
    public function __construct(ContainerInterface $cont)
    {
        parent::__construct($cont);
        $this->soireeService = $cont->get(SoireeService::class);
    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        //Affichage du détail d’une soirée : nom de la soirée, thématique, date et horaire, lieu, tarifs,
        //ainsi que la liste des spectacles : titre, artistes, description, style de musique, vidéo.
        $data = $rq->getAttribute('id');
        if (!isset($data)) {
            throw new HttpBadRequestException($rq, 'Missing soiree_id');
        }

        $soiree = $this->soireeService->getSoireeSpectacleId($data);
        return JsonRenderer::render($rs, 200, $soiree);
    }

}
