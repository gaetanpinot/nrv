<?php

namespace nrv\core\dto;


use nrv\core\domain\entities\Theme\Theme;

class ThemeDTO extends DTO
{
    public int $id;
    public string $label;

    public function __construct(Theme $theme)
    {
        $this->id = $theme->id;
        $this->label = $theme->label;
    }

}