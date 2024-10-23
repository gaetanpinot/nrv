<?php

namespace nrv\back\core\dto;


use nrv\back\core\domain\entities\Theme\Theme;

class ThemeDTO extends DTO
{
    public string $id;
    public string $label;

    public function __construct(Theme $theme)
    {
        $this->id = $theme->id;
        $this->label = $theme->label;
    }

}