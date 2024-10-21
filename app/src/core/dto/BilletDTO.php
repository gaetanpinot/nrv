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
        $this->id = $billet->getId();
        $this->id_user = $billet->getIdUser();
        $this->id_spectacle = $billet->getIdSpectacle();
        $this->tarif = $billet->getTarif();
    }


}