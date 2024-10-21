<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Panier\Panier;

class PanierDTO extends DTO
{
    public string $id;
    public string $email_utilisateur;
    public bool $is_valide;

    public function __construct(Panier $panier)
    {
        $this->id = $panier->getId();
        $this->email_utilisateur = $panier->getEmail();
        $this->is_valide = $panier->getIsValide();
    }


}