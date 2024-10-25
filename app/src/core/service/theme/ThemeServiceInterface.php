<?php
namespace nrv\core\service\Theme;

use nrv\core\dto\ThemeDTO;

interface ThemeServiceInterface
{
    public function getThemes(): array;
    public function getThemeById(int $id_theme): ThemeDTO;
    public function getThemeByLabel(string $label): ThemeDTO;
}