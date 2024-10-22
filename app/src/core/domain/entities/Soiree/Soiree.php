<?php

namespace nrv\core\domain\entities\Soiree;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\UtilisateurDTO;

class Soiree extends Entity
{
    protected string $id;
    protected string $nom;
    protected int $id_theme;
    protected DateTime $date;
    protected DateTime $heureDebut;
    protected DateTime $duree;
    protected string $id_lieu;
    protected int $nbPlaces;
    protected int $nbPlacesRestantes;
    protected float $tarifNormal;
    protected float $tarifReduit;

    public function __construct($id, $nom, $id_theme, $date, $heureDebut, $duree, $id_lieu, $nbPlaces, $nbPlacesRestantes, $tarifNormal, $tarifReduit)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->id_theme = $id_theme;
        $this->date = $date;
        $this->heureDebut = $heureDebut;
        $this->duree = $duree;
        $this->id_lieu = $id_lieu;
        $this->nbPlaces = $nbPlaces;
        $this->nbPlacesRestantes = $nbPlacesRestantes;
        $this->tarifNormal = $tarifNormal;
        $this->tarifReduit = $tarifReduit;
    }
    public function toDTO(): SoireeDTO
    {
        return new SoireeDTO($this);

    }

}