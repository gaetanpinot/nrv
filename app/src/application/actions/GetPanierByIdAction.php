<?php

namespace nrv\application\actions;

use nrv\infrastructure\Exceptions\NoDataFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use nrv\core\service\panier\PanierService;
use nrv\application\renderer\JsonRenderer;
use Respect\Validation\Exceptions\ValidatorException;
use Respect\Validation\Validator;

class GetPanierByIdAction
{
    protected PanierService $panierService;

    public function __construct(PanierService $panierService)
    {
        $this->panierService = $panierService;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];

        Validator::uuid()->assert($id);

        try {
            $panier = $this->panierService->getPanierByUserId($id);
            return JsonRenderer::render($response, 200, $panier);
        } catch(ValidatorException $e) {
            return JsonRenderer::render($response, 400, ['error' => $e->getMessage()]);
        } catch (NoDataFoundException $e) {
            return JsonRenderer::render($response, 404, ['error' => $e->getMessage()]);
        }
        catch (\PDOException $e) {
            return JsonRenderer::render($response, 500, ['error' => $e->getMessage()]);
        }
        catch (\Exception $e) {
            return JsonRenderer::render($response, 500, ['error' => $e->getMessage()]);
        }
    }
}
