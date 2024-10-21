<?php

namespace nrv\core\domain\entities\Artiste;

use nrv\core\domain\entities\Entity;
use nrv\core\dto\ArtisteDTO;

class Artiste extends Entity
{
    public string $id;
    public string $nom;

    public function __construct($id, $nom)
    {
        $this->id = $id;
        $this->nom = $nom;
    }
    public function toDTO(): ArtisteDTO
    {
        return new ArtisteDTO($this->id, $this->nom);

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
}