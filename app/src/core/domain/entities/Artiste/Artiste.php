<?php

namespace nrv\core\domain\entities\Artiste;

use nrv\core\domain\entities\Entity;
use nrv\core\dto\ArtisteDTO;

class Artiste extends Entity
{
    public string $id;
    public string $prenom;

    public function __construct($id, $prenom)
    {
        $this->id = $id;
        $this->prenom = $prenom;
    }
    public function toDTO(): ArtisteDTO
    {
        return new ArtisteDTO($this);

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }
}