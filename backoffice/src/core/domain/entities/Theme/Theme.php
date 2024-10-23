<?php

namespace nrv\core\domain\entities\Theme;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\ThemeDTO;
use nrv\core\dto\UtilisateurDTO;

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