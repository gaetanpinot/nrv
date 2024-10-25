<?php
namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use nrv\infrastructure\Exceptions\NoDataFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use DI\Container;
use nrv\application\renderer\JsonRenderer;
use Respect\Validation\Exceptions\ValidatorException;
use Respect\Validation\Validator;

class ConnexionAction extends AbstractAction
{
    protected UtilisateurService $utilisateurService;

    public function __construct(Container $cont, UtilisateurService $utilisateurService)
    {
        parent::__construct($cont);
        $this->utilisateurService = $utilisateurService;
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $data = $rq->getParsedBody();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        Validator::email()->assert($email);
        Validator::stringType()->assert($password);

        if (empty($email) || empty($password)) {
            $this->loger->warning('Email ou mot de passe manquant.');
            return JsonRenderer::render($rs, 400, ['error' => 'Email ou mot de passe manquant.']);
        }

        try {
            $jwt = $this->utilisateurService->connexion($email, $password);
            return JsonRenderer::render($rs, 200, ['token' => $jwt]);
        }catch (ValidatorException $e) {
            return JsonRenderer::render($rs, 400, ['error' => $e->getMessage()]);
        } catch (NoDataFoundException){
            return JsonRenderer::render($rs, 404, ['error' => 'Utilisateur non trouvé.']);
        }
        catch (\PDOException $e) {
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
        catch (\Exception $e) {
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
    }
}
