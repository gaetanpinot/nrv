<?php
namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\Container;
use nrv\application\renderer\JsonRenderer;
use Psr\Log\LoggerInterface;
use Respect\Validation\Validator;

class InscriptionAction extends AbstractAction
{
    protected UtilisateurService $utilisateurService;

    public function __construct(Container $cont, UtilisateurService $utilisateurService)
    {
        parent::__construct($cont);
        $this->utilisateurService = $utilisateurService;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        $data = $rq->getParsedBody();

        if (empty($data['email']) || empty($data['prenom']) || empty($data['nom']) || empty($data['password'])) {
            $this->loger->warning('Champs requis manquants lors de l\'inscription');
            return JsonRenderer::render($rs, 400, [
                'error' => "Tous les champs sont requis"
            ]);
        }

        try {
            Validator::key('email', Validator::email()
                ->key('prenom', Validator::stringType()->notEmpty())
                ->key('nom', Validator::stringType()->notEmpty())
                ->key('password', Validator::stringType()->notEmpty()))
                ->assert($data);

            $utilisateurDTO = $this->utilisateurService->inscription(
                $data['email'],
                $data['prenom'],
                $data['nom'],
                $data['password']
            );



            return JsonRenderer::render($rs, 201, [
                'message' => 'Inscription réussie',
                'utilisateur' => $utilisateurDTO
            ]);

        }catch (\PDOException $e) {
            return JsonRenderer::render($rs, 500, [
                'error' => $e->getMessage()
            ]);
        }
        catch (\Respect\Validation\Exceptions\ValidationException $e) {
            return JsonRenderer::render($rs, 400, [
                'error' => $e->getMessage()
            ]);
        }
        catch (\Exception $e) {
            return JsonRenderer::render($rs, 500, [
                'error' => $e->getMessage()
            ]);
        }

    }
}
