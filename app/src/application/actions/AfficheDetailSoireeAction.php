<?php

namespace nrv\application\actions;

use DI\Container;
use nrv\application\renderer\JsonRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;

class AfficheDetailSoireeAction extends AbstractAction
{

//    public function __construct(Container $cont)
//    {
//        $this->soireeService = $cont->get(SoireeService::class);
//    }
    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        //Affichage du détail d’une soirée : nom de la soirée, thématique, date et horaire, lieu, tarifs,
        //ainsi que la liste des spectacles : titre, artistes, description, style de musique, vidéo.
        $data = $rq->getParsedBody();

        if (!isset($data['soiree_id'])) {
            throw new HttpBadRequestException($rq, 'Données manquantes ou invalides');
        }

        $soiree = $this->soireeService->getSoiree($data['soiree_id']);
        return JsonRenderer::render($rs, 200, $soiree);
    }
}