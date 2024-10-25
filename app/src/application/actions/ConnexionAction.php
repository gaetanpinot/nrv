<?php
namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use DI\Container;
use nrv\application\renderer\JsonRenderer;

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

        if (empty($email) || empty($password)) {
            $this->loger->warning('Email ou mot de passe manquant.');
            return JsonRenderer::render($rs, 400, ['error' => 'Email ou mot de passe manquant.']);
        }

        try {
            $jwt = $this->utilisateurService->connexion($email, $password);
            return JsonRenderer::render($rs, 200, ['token' => $jwt]);
        } catch (\Exception $e) {
            $this->loger->error('Erreur de connexion : ' . $e->getMessage());
            return JsonRenderer::render($rs, 401, ['error' => $e->getMessage()]);
        }
    }
}
