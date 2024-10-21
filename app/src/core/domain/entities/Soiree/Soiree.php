<?php

namespace nrv\core\domain\entities\Soiree;

use DateTime;
use nrv\core\domain\entities\Entity;
use nrv\core\dto\SoireeDTO;
use nrv\core\dto\UtilisateurDTO;

class Soiree extends Entity
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
    public function toDTO(): SoireeDTO
    {
        return new SoireeDTO($this->id, $this->nom, $this->id_theme, $this->date, $this->heureDebut, $this->duree, $this->id_lieu, $this->nbPlaceAssiseRestante, $this->nbPlaceDeboutRestante, $this->tarifNormal, $this->tarifReduit);

    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getIdTheme(): int
    {
        return $this->id_theme;
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getHeureDebut(): DateTime
    {
        return $this->heureDebut;
    }

    public function getDuree(): DateTime
    {
        return $this->duree;
    }

    public function getIdLieu(): string
    {
        return $this->id_lieu;
    }

    public function getNbPlaceAssiseRestante(): int
    {
        return $this->nbPlaceAssiseRestante;
    }

    public function getNbPlaceDeboutRestante(): int
    {
        return $this->nbPlaceDeboutRestante;
    }

    public function getTarifNormal(): float
    {
        return $this->tarifNormal;
    }

    public function getTarifReduit(): float
    {
        return $this->tarifReduit;
    }

}