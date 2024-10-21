<?php

namespace nrv\core\domain\entities\Panier;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\PanierDTO;
use nrv\core\dto\UtilisateurDTO;

class Panier extends Entity
{
    public ?string $id;
    public bool $is_valide;

    public function __construct($id, $is_valide)
    {
        $this->id = $id;
        $this->is_valide = $is_valide;
    }
    public function toDTO(): PanierDTO
    {
        return new PanierDTO($this->id, $this->is_valide);

    }

}