<?php

namespace nrv\back\application\actions;

use DI\Container;
use PHPUnit\Exception;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpInternalServerErrorException;
use nrv\back\application\renderer\JsonRenderer;
use nrv\back\core\service\spectacle\SpectacleService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class AjouterSpectacleAction extends AbstractAction
{
    private SpectacleService $spectacleService;

    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->spectacleService = $container->get(SpectacleService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $spectacle = $rq->getParsedBody();
        $validatorSpectacle = Validator::key('titre', Validator::stringType()->notEmpty())
            ->key('description', Validator::stringType()->notEmpty())
            ->key('url_image', Validator::url())
            ->key('url_video', Validator::url())
            ->key('artistes',Validator::arrayType());
        try{
            $validatorSpectacle->assert($spectacle);
            $this->spectacleService->addSpectacle($spectacle);
        }catch(NestedValidationException $e){
            throw new HttpBadRequestException($rq, $e->getMessage());
        }catch(Exception $e){
            throw new HttpInternalServerErrorException($rq, $e->getMessage());
        }
        return JsonRenderer::render($rs, 200, "Ajouté avec succès");
    }
}
