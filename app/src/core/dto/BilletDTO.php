<?php

namespace nrv\core\dto;


class BilletDTO extends DTO
{
    public string $id;
    public string $id_user;
    public string $id_spectacle;
    public float $tarif;

    public function __construct($id, $id_user, $id_spectacle, $tarif)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_spectacle = $id_spectacle;
        $this->tarif = $tarif;
    }


}