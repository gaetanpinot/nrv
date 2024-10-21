<?php
namespace nrv\core\dto;

use nrv\core\domain\entities\Lieu\Lieu;
use nrv\core\dto\DTO;

class LieuDTO extends DTO{
    
    public string $id;
    public string $nom;
    public string $adresse;
    public string $nb_places_assises;
    public string $nb_places_debout;
    public array $images;

    public function __construct(Lieu $lieu){
        $this->id = $lieu->getId();
        $this->nom = $lieu->getNom();
        $this->adresse = $lieu->getAdresse();
        $this->nb_places_assises = $lieu->getNbPlacesAssises();
        $this->nb_places_debout = $lieu->getNbPlacesDebout();
        $this->images = $lieu->getImages();
    }
}