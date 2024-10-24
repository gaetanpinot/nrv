<?php
namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\Container;

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
            return $this->errorResponse($rs, "Tous les champs sont requis", 400);
        }

        try {
            $utilisateurDTO = $this->utilisateurService->inscription(
                $data['email'],
                $data['prenom'],
                $data['nom'],
                $data['password']
            );

            return $this->jsonResponse($rs, [
                'message' => 'Inscription réussie',
                'utilisateur' => $utilisateurDTO
            ], 201);

        } catch (\Exception $e) {
            $this->loger->error('Erreur lors de l\'inscription : ' . $e->getMessage());
            return $this->errorResponse($rs, $e->getMessage(), 400);
        }
    }

    private function jsonResponse(Response $response, array $data, int $status): Response
    {
        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($data));
        return $response->withStatus($status);
    }

    private function errorResponse(Response $response, string $message, int $status): Response
    {
        return $this->jsonResponse($response, ['error' => $message], $status);
    }
}

