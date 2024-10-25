<?php
namespace nrv\application\actions;

use nrv\core\service\utilisateur\UtilisateurService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use DI\Container;
use nrv\application\renderer\JsonRenderer;
use Psr\Log\LoggerInterface;

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

        } catch (\Exception $e) {
            $this->loger->error('Erreur lors de l\'inscription : ' . $e->getMessage());
            return JsonRenderer::render($rs, 400, [
                'error' => $e->getMessage()
            ]);
        }
    }
}
