<?php
namespace nrv\application\actions;

use nrv\infrastructure\Exceptions\NoDataFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\core\service\billet\BilletService;
use DI\Container;
use nrv\application\renderer\JsonRenderer;
use Respect\Validation\Validator;

class GetUserBilletsAction extends AbstractAction
{
    protected BilletService $billetService;

    public function __construct(Container $cont, BilletService $billetService)
    {
        parent::__construct($cont);
        $this->billetService = $billetService;
    }

    public function __invoke(Request $rq, Response $rs, array $args): Response
    {
        try {
            $userId = $args['id'];
            Validator::uuid()->assert($userId);

            $billets = $this->billetService->getBilletsByUserId($userId);
            return JsonRenderer::render($rs, 200, $billets);
        } catch (\Respect\Validation\Exceptions\ValidationException $e) {
            return JsonRenderer::render($rs, 400, ['error' => $e->getMessage()]);
        } catch (NoDataFoundException $e) {
            return JsonRenderer::render($rs, 404, ['error' => $e->getMessage()]);
        }
        catch (\PDOException $e) {
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
        catch (\Exception $e) {
            $this->loger->error("Erreur lors de la récupération des billets de l'utilisateur {$userId} : " . $e->getMessage());
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
    }
}
