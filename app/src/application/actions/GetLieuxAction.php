<?php
namespace nrv\application\actions;

use DI\Container;
use nrv\core\service\lieu\LieuService;
use nrv\core\service\lieu\LieuServiceInterface;
use nrv\infrastructure\Exceptions\NoDataFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use nrv\application\renderer\JsonRenderer;

class GetLieuxAction extends AbstractAction{

    private LieuServiceInterface $lieuService;
    public function __construct(Container $cont){
        parent::__construct($cont);
        $this->lieuService = $cont->get(LieuService::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $lieux = $this->lieuService->getLieux();
            return JsonRenderer::render($rs, 200, $lieux);
        }
        catch (NoDataFoundException $e) {
            return JsonRenderer::render($rs, 404, ['status' => 'error', 'message' => $e->getMessage()]);
        }
        catch (\PDOException $e) {
            return JsonRenderer::render($rs, 500, ['status' => 'error', 'message' => $e->getMessage()]);
        }
        catch (\Exception $e) {
            return JsonRenderer::render($rs, 500, ['status' => 'error', 'message' => $e->getMessage()]);
        }

    }
}