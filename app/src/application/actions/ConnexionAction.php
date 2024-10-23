<?php
namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use DI\Container;

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
            $rs->getBody()->write(json_encode(['error' => 'Email ou mot de passe manquant.']));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $jwt = $this->utilisateurService->connexion($email, $password);
            $rs->getBody()->write(json_encode(['token' => $jwt]));
            return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $this->loger->error('Erreur de connexion : ' . $e->getMessage());
            $rs->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $rs->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}

