<?php

namespace nrv\back\core\domain\entities\Billet;

use DateTime;
use nrv\back\core\domain\entities\Entity;
use nrv\back\core\dto\BilletDTO;
use nrv\back\core\dto\UtilisateurDTO;

class Billet extends Entity
{
    protected string $id;
    protected string $id_user;
    protected string $id_spectacle;
    protected float $tarif;

    public function __construct($id, $id_user, $id_spectacle, $tarif)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->id_spectacle = $id_spectacle;
        $this->tarif = $tarif;
    }

    public function toDTO(): BilletDTO
    {
        return new BilletDTO($this);
    }

}