<?php

namespace nrv\core\dto;


use nrv\core\domain\entities\Billet\Billet;

class BilletDTO extends DTO
{
    public string $id;
    public string $id_utilisateur;
    public string $id_spectacle;
    public float $tarif;

    public function __construct(Billet $billet)
    {
        $this->id = $billet->id;
        $this->id_utilisateur = $billet->id_utilisateur;
        $this->id_spectacle = $billet->id_soiree;
        $this->tarif = $billet->tarif;
    }


}
