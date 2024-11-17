<?php

namespace nrv\core\domain\entities\Billet;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\dto\BilletDTO;
use nrv\core\dto\UtilisateurDTO;

class Billet extends Entity
{
    protected string $id;
    protected string $id_utilisateur;
    protected Soiree $soiree;
    protected float $tarif;

    public function __construct($id, $id_utilisateur, Soiree $soiree, $tarif)
    {
        $this->id = $id;
        $this->id_utilisateur = $id_utilisateur;
        $this->soiree = $soiree;
        $this->tarif = $tarif;
    }

    public function toDTO(): BilletDTO
    {
        return new BilletDTO($this);
    }

}
