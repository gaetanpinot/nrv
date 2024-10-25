<?php
namespace nrv\back\core\service\theme;

use nrv\back\core\dto\ThemeDTO;

interface ThemeServiceInterface
{
    public function getThemes(): array;
    public function getThemeById(int $id_theme): ThemeDTO;
    public function getThemeByLabel(string $label): ThemeDTO;
}
