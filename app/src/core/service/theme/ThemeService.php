<?php
namespace nrv\core\service\theme;

use DI\Container;
use nrv\core\domain\entities\Theme\Theme;
use nrv\core\dto\ThemeDTO;
use nrv\core\repository\ThemeRepository;
use nrv\core\repositoryInterfaces\ThemeRepositoryInterface;
class ThemeService implements ThemeServiceInterface{

    protected ThemeRepositoryInterface $themeRepository;

    public function __construct(Container $cont){
        $this->themeRepository = $cont->get(ThemeRepositoryInterface::class);
    }

    public function getThemes(): array{
        $themes = $this->themeRepository->getThemes();
        $res = array();
        foreach ($themes as $theme) {
            $theme = new Theme($theme['id'], $theme['label']);
            $res[] = new ThemeDTO($theme);
        }
        return $res;
    }

    public function getThemeById(int $id_theme): ThemeDTO{
        $theme = $this->themeRepository->getThemeById($id_theme);
        if (!$theme) {
            throw new \Exception("theme non trouvé : $id_theme");
        }
        return new ThemeDTO($theme['id'], $theme['label']);
    }

    public function getThemeByLabel(string $label): ThemeDTO{
        $theme = $this->themeRepository->getThemeByLabel($label);
        if (!$theme) {
            throw new \Exception("theme non trouvé : $label");
        }
        return new ThemeDTO($theme['id'], $theme['label']);
    }
}