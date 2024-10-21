<?php

namespace nrv\core\dto;


class ThemeDTO extends DTO
{
    public string $id;
    public string $labelle;

    public function __construct($id, $labelle)
    {
        $this->id = $id;
        $this->labelle = $labelle;
    }

}