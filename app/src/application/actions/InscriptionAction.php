<?php

namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class InscriptionAction
{
    protected UtilisateurService $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function inscription(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (empty($data['email']) || empty($data['prenom']) || empty($data['nom']) || empty($data['password'])) {
            return $this->errorResponse($response, "Tous les champs sont requis", 400);
        }

        try {
            $utilisateurDTO = $this->utilisateurService->inscription(
                $data['email'],
                $data['prenom'],
                $data['nom'],
                $data['password']
            );

            return $this->jsonResponse($response, [
                'message' => 'Inscription reussie',
                'utilisateur' => $utilisateurDTO
            ], 201);

        } catch (\Exception $e) {
            return $this->errorResponse($response, $e->getMessage(), 400);
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
