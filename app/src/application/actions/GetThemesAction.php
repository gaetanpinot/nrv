<?php
namespace nrv\application\actions;

use DI\Container;
use nrv\infrastructure\Exceptions\NoDataFoundException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use nrv\application\renderer\JsonRenderer;
use nrv\core\service\theme\ThemeServiceInterface;

class GetThemesAction extends AbstractAction{

    private ThemeServiceInterface $themeService;
    public function __construct(Container $cont){
        parent::__construct($cont);
        $this->themeService = $cont->get(ThemeServiceInterface::class);
    }

    public function __invoke(ServerRequestInterface $rq, ResponseInterface $rs, array $args): ResponseInterface
    {
        try {
            $themes = $this->themeService->getThemes();
            return JsonRenderer::render($rs, 200, $themes);
        }
        catch (NoDataFoundException $e) {
            return JsonRenderer::render($rs, 404, ['error' => $e->getMessage()]);
        } catch (\PDOException $e) {
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }
            catch (\Exception $e) {
            return JsonRenderer::render($rs, 500, ['error' => $e->getMessage()]);
        }

    }
}