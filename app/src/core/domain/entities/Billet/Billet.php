<?php

namespace nrv\core\domain\entities\Billet;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\BilletDTO;
use nrv\core\dto\UtilisateurDTO;

class Billet extends Entity
{
    protected string $id;
    protected string $id_utilisateur;
    protected string $id_soiree;
    protected float $tarif;

    public function __construct($id, $id_utilisateur, $id_soiree, $tarif)
    {
        $this->id = $id;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_soiree = $id_soiree;
        $this->tarif = $tarif;
    }

    public function toDTO(): BilletDTO
    {
        return new BilletDTO($this);
    }

}
