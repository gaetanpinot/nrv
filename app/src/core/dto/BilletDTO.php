<?php

namespace nrv\core\dto;


use nrv\core\domain\entities\Billet\Billet;

class BilletDTO extends DTO
{
    public string $id;
    public string $id_utilisateur;
    public SoireeDTO $soiree;
    public float $tarif;

    public function __construct(Billet $billet)
    {
        $this->id = $billet->id;
        $this->id_utilisateur = $billet->id_utilisateur;
        $this->soiree = new SoireeDTO($billet->soiree);
        $this->tarif = $billet->tarif;
    }


}
