<?php

namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response;

class ConnexionAction
{
    protected UtilisateurService $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function __invoke(Request $request, Response $response): ResponseInterface
    {
        $data = $request->getParsedBody();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($email) || empty($password)) {
            $response->getBody()->write(json_encode(['error' => 'Email ou mot de passe manquant.']));
            return $response->withStatus(400)->withHeader('Content-Type', 'application/json');
        }

        try {
            $jwt = $this->utilisateurService->connexion($email, $password);
            $response->getBody()->write(json_encode(['token' => $jwt]));
            return $response->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withStatus(401)->withHeader('Content-Type', 'application/json');
        }
    }
}
