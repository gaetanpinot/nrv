<?php

namespace nrv\back\core\domain\entities\Theme;

use DateTime;
use nrv\back\core\domain\entities\Entity;
use nrv\back\core\dto\SoireeDTO;
use nrv\back\core\dto\ThemeDTO;
use nrv\back\core\dto\UtilisateurDTO;

class Theme extends Entity
{
    protected string $id;
    protected string $label;

    public function __construct($id, $label)
    {
        $this->id = $id;
        $this->label = $label;
    }
    public function toDTO(): ThemeDTO
    {
        return new ThemeDTO($this);

    }

}