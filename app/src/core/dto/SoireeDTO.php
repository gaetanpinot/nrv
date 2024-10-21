<?php

namespace nrv\core\dto;



use DateTime;

class SoireeDTO extends DTO
{
    public string $id;
    public string $nom;
    public int $id_theme;
    public DateTime $date;
    public DateTime $heureDebut;
    public DateTime $duree;
    public string $id_lieu;
    public int $nbPlaceAssiseRestante;
    public int $nbPlaceDeboutRestante;
    public float $tarifNormal;
    public float $tarifReduit;

    public function __construct($id, $nom, $id_theme, $date, $heureDebut, $duree, $id_lieu, $nbPlaceAssiseRestante, $nbPlaceDeboutRestante, $tarifNormal, $tarifReduit)
    {
        $this->id = $id;
        $this->nom = $nom;
        $this->id_theme = $id_theme;
        $this->date = $date;
        $this->heureDebut = $heureDebut;
        $this->duree = $duree;
        $this->id_lieu = $id_lieu;
        $this->nbPlaceAssiseRestante = $nbPlaceAssiseRestante;
        $this->nbPlaceDeboutRestante = $nbPlaceDeboutRestante;
        $this->tarifNormal = $tarifNormal;
        $this->tarifReduit = $tarifReduit;
    }


}