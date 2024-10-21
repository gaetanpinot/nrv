<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Artiste\Artiste;

class ArtisteDTO extends DTO
{
    public string $id;
    public string $nom;

    public function __construct(Artiste $artiste)
    {
        $this->id = $artiste->getId();
        $this->nom = $artiste->getNom();
    }
}