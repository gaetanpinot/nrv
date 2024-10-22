<?php

namespace nrv\core\domain\entities\Theme;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\ThemeDTO;
use nrv\core\dto\UtilisateurDTO;

class Theme extends Entity
{
    public string $id;
    public string $label;

    public function __construct($id, $label)
    {
        $this->id = $id;
        $this->label = $label;
    }
    public function toDTO(): ThemeDTO
    {
        return new ThemeDTO($this);

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

}