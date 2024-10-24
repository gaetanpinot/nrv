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
    protected bool $is_valide;

    public function __construct($id, $id_utilisateur, $is_valide)
    {
        $this->id = $id;
        $this->id_utilisateur = $id_utilisateur;
        $this->is_valide = $is_valide;
    }
    public function toDTO(): PanierDTO
    {
        return new PanierDTO($this);
    }

<<<<<<< HEAD
=======
    public function getIdBillet(): ?string
    {
        return $this->id_billet;
    }

    public function setIdBillet(string $id_billet): void
    {
        $this->id_billet = $id_billet;
    }

    public function setValide(bool $is_valide): void
    {
        $this->is_valide = $is_valide;
    }

>>>>>>> 7ad73aff5eecad61c025105c201e11e6ec29a36d
}