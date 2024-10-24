<?php
namespace nrv\application\actions;

use DI\Container;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Exception\HttpBadRequestException;
use nrv\application\renderer\JsonRenderer;
use nrv\application\actions\AbstractAction;
use nrv\core\service\soiree\SoireeServiceInterface;

class GetSoireesSpectaclesAction extends AbstractAction{
    
    private SoireeServiceInterface $soireeService;
    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->soireeService = $cont->get(SoireeServiceInterface::class);
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
