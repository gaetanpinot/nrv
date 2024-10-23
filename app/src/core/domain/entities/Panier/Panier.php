<?php

namespace nrv\core\domain\entities\Panier;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\PanierDTO;
use nrv\core\dto\UtilisateurDTO;

class Panier extends Entity
{
    protected string $id;
    protected string $id_utilisateur;
    protected ?string $id_billet;
    protected bool $is_valide;

    public function __construct($id, $id_utilisateur, $id_billet, $is_valide)
    {
        $this->id = $id;
        $this->id_utilisateur = $id_utilisateur;
        $this->id_billet = $id_billet;
        $this->is_valide = $is_valide;
    }
    public function toDTO(): PanierDTO
    {
        return new PanierDTO($this);
    }

    public function getIdBillet(): ?string
    {
        return $this->id_billet;
    }

    public function setIdBillet(string $id_billet): void
    {
        $this->id_billet = $id_billet;
    }

}