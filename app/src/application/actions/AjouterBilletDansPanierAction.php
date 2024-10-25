<?php

namespace nrv\application\actions;

use DI\Container;
use nrv\application\renderer\JsonRenderer;
use nrv\core\service\billet_panier\BilletPanierService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Respect\Validation\Exceptions\ValidatorException;
use Respect\Validation\Validator;

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
        try {
        $data = $rq->getParsedBody();
        $id_utilisateur = $data['id_utilisateur'];
        $id_soiree = $data['id_soiree'];
        $tarif = 0;

        Validator::uuid()->assert($id_utilisateur);
        Validator::uuid()->assert($id_soiree);

            $this->billetPanierService->ajouterBilletAuPanier($id_utilisateur, $id_soiree, $tarif);
            return  JsonRenderer::render($rs, 200, ['status' => 'success', 'message' => 'Billet ajouté au panier']);
        }  catch (ValidatorException $e) {
            return JsonRenderer::render($rs, 400, ['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\PDOException $e) {
            return JsonRenderer::render($rs, 500, ['status' => 'error', 'message' => $e->getMessage()]);
        }

        catch (\Exception $e) {
            return JsonRenderer::render($rs, 500, ['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
