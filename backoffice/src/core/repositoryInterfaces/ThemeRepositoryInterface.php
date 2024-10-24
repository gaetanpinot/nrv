<?php

namespace nrv\back\core\repositoryInterfaces;

use nrv\back\core\domain\entities\Artiste\Artiste;
use nrv\back\core\domain\entities\Billet\Billet;
use nrv\back\core\domain\entities\Theme\Theme;
use PhpParser\Node\Stmt\Label;

interface ThemeRepositoryInterface
{
    public function getTheme(): array;
    public function getThemeById(string $id): Theme;
    public function save(Theme $label): void;
    public function updateTheme(Theme $label): void;
    public function deleteTheme(string $id): void;
}