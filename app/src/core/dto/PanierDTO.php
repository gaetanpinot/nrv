<?php

namespace nrv\core\dto;

class PanierDTO extends DTO
{
    public string $id;
    public bool $is_valide;

    public function __construct($id, $is_valide)
    {
        $this->id = $id;
        $this->is_valide = $is_valide;
    }


}