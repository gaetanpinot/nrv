<?php

namespace nrv\core\domain\entities\Soiree;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\domain\entities\Lieu\Lieu;
use nrv\core\domain\entities\Theme\Theme;
use nrv\core\dto\SoireeDTO;

class Soiree extends Entity
{
    protected string $id;
    protected string $nom;
    protected Theme $theme;
    protected DateTime $date;
    protected DateTime $heure_debut;
    protected DateTime $duree;
    protected Lieu $lieu;
    protected array $spectacles;
    protected int $nb_places_assises_restantes;
    protected int $nb_places_debout_restantes;
    protected float $tarif_normal;
    protected float $tarif_reduit;

    public function __construct($id = "",
        $nom = "",
        Theme $theme = new Theme('',''),
        $date = "1-1-1",
        $heure_debut = "00:00:00",
        $duree = "00:00:00", 
        $lieu = new Lieu(),
        $spectacles = [],
        $nb_places_assises_restantes = 0,
        $nb_places_debout_restantes = 0,
        $tarif_normal = 0,
        $tarif_reduit = 0)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->theme = $theme;
        $this->date = DateTime::createFromFormat('Y-m-d', $date);
        $this->heure_debut = DateTime::createFromFormat('H:i:s', $heure_debut);
        $this->duree = DateTime::createFromFormat('H:i:s', $duree);
        $this->lieu = $lieu;
        $this->spectacles = $spectacles;
        $this->nb_places_assises_restantes = $nb_places_assises_restantes;
        $this->nb_places_debout_restantes = $nb_places_debout_restantes;
        $this->tarif_normal = $tarif_normal;
        $this->tarif_reduit = $tarif_reduit;
    }
    public function toDTO(): SoireeDTO
    {
        return new SoireeDTO($this);

    }

}
