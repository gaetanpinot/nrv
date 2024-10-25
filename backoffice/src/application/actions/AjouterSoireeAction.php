<?php

namespace nrv\back\application\actions;

use DI\Container;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use nrv\back\application\renderer\JsonRenderer;
use nrv\back\core\service\soiree\SoireeService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AjouterSoireeAction extends AbstractAction
{
    private SoireeService $soireeService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->soireeService = $container->get(SoireeService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $soiree = $rq->getParsedBody();
        $validatorSoiree= Validator::key('nom', Validator::stringType())
            ->key('id_theme', Validator::intVal())
            ->key('date', Validator::dateTime('Y-m-d'))
            ->key('heure_debut', Validator::dateTime('H:i'))
            ->key('duree', Validator::dateTime('H:i'))
            ->key('lieu_id', Validator::Uuid())
            ->key('tarif_normal', Validator::number())
            ->key('tarif_reduit', Validator::number())
            ->key('spectacles', Validator::arrayType());
        try{
            $validatorSoiree->assert($soiree);
            $this->soireeService->addSoiree($soiree);
        }catch(NestedValidationException $e){
            throw new HttpBadRequestException($rq, $e->getMessage());
        }
        return JsonRenderer::render($rs, 201, "Ajouté avec succès");
    }
}
