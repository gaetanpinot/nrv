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
    public DateTime $heureDebut;
    public DateTime $duree;
    public string $id_lieu;
    public int $nbPlaces;
    public int $nbPlacesRestantes;
    public float $tarifNormal;
    public float $tarifReduit;

    public function __construct(Soiree $soiree)
    {
        $this->id = $soiree->id;
        $this->nom = $soiree->nom;
        $this->id_theme = $soiree->id_theme;
        $this->date = $soiree->date;
        $this->heureDebut = $soiree->heureDebut;
        $this->duree = $soiree->duree;
        $this->id_lieu = $soiree->id_lieu;
        $this->nbPlaces = $soiree->nbPlaces;
        $this->nbPlacesRestantes = $soiree->nbPlacesRestantes;
        $this->tarifNormal = $soiree->tarifNormal;
        $this->tarifReduit = $soiree->tarifReduit;
    }


}