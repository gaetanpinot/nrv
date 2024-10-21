<?php
namespace nrv\core\domain\entities;

use nrv\core\dto\LieuDTO;
use nrv\core\domain\entities\Entity;

class Lieu extends Entity{
    
    protected string $id;
    protected string $nom;
    protected string $adresse;
    protected string $nb_places_assises;
    protected string $nb_places_debout;
    protected array $images;

    public function __construct(string $id, string $nom, string $adresse, string $nb_places_assises, string $nb_places_debout, array $images){
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->nb_places_assises = $nb_places_assises;
        $this->nb_places_debout = $nb_places_debout;
        $this->images = $images;
    }

    public function toDTO(): LieuDTO{
        return new LieuDTO($this);
    }

    public function getNom(): string{
        return $this->nom;
    }

    public function getAdresse(): string{
        return $this->adresse;
    }

    public function getNbPlacesAssises(): string{
        return $this->nb_places_assises;
    }

    public function getNbPlacesDebout(): string{
        return $this->nb_places_debout;
    }

    public function getImages(): array{
        return $this->images;
    }
}