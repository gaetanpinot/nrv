<?php

namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Theme\Theme;
use PhpParser\Node\Stmt\Label;

interface ThemeRepositoryInterface
{
    public function getThemes(): array;
    public function getThemeById(int $id): Theme;
    public function getThemeByLabel(string $label): Theme;
    public function save(Theme $label): void;
    public function updateTheme(Theme $label): void;
    public function deleteTheme(string $id): void;
}