<?php

namespace nrv\core\dto;


use nrv\core\domain\entities\Billet\Billet;

class BilletDTO extends DTO
{
    public string $id;
    public string $id_user;
    public string $id_spectacle;
    public float $tarif;

    public function __construct(Billet $billet)
    {
        $this->id = $billet->id;
        $this->id_user = $billet->id_user;
        $this->id_spectacle = $billet->id_spectacle;
        $this->tarif = $billet->tarif;
    }


}