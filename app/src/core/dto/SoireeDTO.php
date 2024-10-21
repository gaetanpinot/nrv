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
    public int $nbPlaceAssiseRestante;
    public int $nbPlaceDeboutRestante;
    public float $tarifNormal;
    public float $tarifReduit;

    public function __construct(Soiree $soiree)
    {
        $this->id = $soiree->getId();
        $this->nom = $soiree->getNom();
        $this->id_theme = $soiree->getIdTheme();
        $this->date = $soiree->getDate();
        $this->heureDebut = $soiree->getHeureDebut();
        $this->duree = $soiree->getDuree();
        $this->id_lieu = $soiree->getIdLieu();
        $this->nbPlaceAssiseRestante = $soiree->getNbPlaceAssiseRestante();
        $this->nbPlaceDeboutRestante = $soiree->getNbPlaceDeboutRestante();
        $this->tarifNormal = $soiree->getTarifNormal();
        $this->tarifReduit = $soiree->getTarifReduit();
    }


}