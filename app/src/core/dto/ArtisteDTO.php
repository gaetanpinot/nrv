<?php

namespace nrv\core\dto;

class ArtisteDTO extends DTO
{
    public string $id;
    public string $nom;

    public function __construct($id, $nom)
    {
        $this->id = $id;
        $this->nom = $nom;
    }
}