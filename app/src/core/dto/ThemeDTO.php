<?php

namespace nrv\core\dto;


use nrv\core\domain\entities\Theme\Theme;

class ThemeDTO extends DTO
{
    public string $id;
    public string $labelle;

    public function __construct(Theme $theme)
    {
        $this->id = $theme->getId();
        $this->labelle = $theme->getLabelle();
    }

}