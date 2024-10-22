<?php

namespace nrv\core\dto;



use DateTime;
use nrv\core\domain\entities\Soiree\Soiree;

class SoireeDTO extends DTO
{
    public string $id;
    public string $nom;
    public int $id_theme;
    public DateTime $date;
    public DateTime $heure_debut;
    public DateTime $duree;
    public string $id_lieu;
    public int $nb_places_assises_restantes;
    public int $nb_places_debout_restantes;
    public float $tarif_normal;
    public float $tarif_reduit;

    public function __construct(Soiree $soiree)
    {
        $this->id = $soiree->id;
        $this->nom = $soiree->nom;
        $this->id_theme = $soiree->id_theme;
        $this->date = $soiree->date;
        $this->heure_debut = $soiree->heure_debut;
        $this->duree = $soiree->duree;
        $this->id_lieu = $soiree->id_lieu;
        $this->nb_places_assises_restantes = $soiree->nb_places_assises_restantes;
        $this->nb_places_debout_restantes = $soiree->nb_places_debout_restantes;
        $this->tarif_normal = $soiree->tarif_normal;
        $this->tarif_reduit = $soiree->tarif_reduit;
    }

}