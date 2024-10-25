<?php

namespace nrv\application\actions;

use DI\Container;
use nrv\application\renderer\JsonRenderer;
use nrv\core\service\billet_panier\BilletPanierService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\ValidatorException;
use Respect\Validation\Validator;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AjouterBilletDansPanierAction extends AbstractAction
{
    protected BilletPanierService $billetPanierService;

    public function __construct(Container $cont)
    {
        parent::__construct($cont);
        $this->billetPanierService = $cont->get(BilletPanierService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        $authHeader = $rq->getHeaderLine('Authorization');
        if (strpos($authHeader, 'Bearer ') === 0) {
            $token = substr($authHeader, 7);
        } else {
            return $rs->withStatus(401)->withHeader('Content-Type', 'application/json')
                ->getBody()->write(json_encode(['status' => 'error', 'message' => 'Token non fourni']));
        }

        try {
            $decoded = JWT::decode($token, new Key(getenv('JWT_SECRET_KEY'), 'HS256'));
            $userId = $decoded->sub ?? null;

            if (!$userId) {
                throw new \Exception('Utilisateur non trouvé dans le token');
            }

            $data = json_decode($rq->getBody()->getContents(), true);
            $idSoiree = $data['soiree'];
            $tarif = $data['tarif'];
            $place = $data['place'];

            $this->billetPanierService->ajouterBilletAuPanier($userId, $idSoiree, $tarif, $place);

            $rs->getBody()->write(json_encode(['status' => 'success', 'message' => 'Billet ajouté au panier']));
            return $rs->withStatus(200)->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {

            $rs->getBody()->write(json_encode(['status' => 'error', 'message' => $e->getMessage()]));
            return $rs->withStatus(400)->withHeader('Content-Type', 'application/json');
        }
    }

}
