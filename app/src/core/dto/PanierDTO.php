<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Panier\Panier;

class PanierDTO extends DTO
{
    public string $id;
    public string $id_utilisateur;
    public string $id_billet;
    public bool $is_valide;

    public function __construct(Panier $panier)
    {
        $this->id = $panier->id;
        $this->id_utilisateur = $panier->id_utilisateur;
        $this->id_billet = $panier->id_billet;
        $this->is_valide = $panier->is_valide;
    }

}