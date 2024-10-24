<?php
namespace nrv\application\actions;

use DI\Container;
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
        $themes = $this->themeService->getThemes();
        return JsonRenderer::render($rs, 200, $themes);
    }
}