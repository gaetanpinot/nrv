<?php
namespace nrv\back\core\dto;

use nrv\back\core\domain\entities\Lieu\Lieu;
use nrv\back\core\dto\DTO;

class LieuDTO extends DTO{
    
    public string $id;
    public string $nom;
    public string $adresse;
    public string $nb_places_assises;
    public string $nb_places_debout;
    public array $lien_image;

    public function __construct(Lieu $lieu){
        $this->id = $lieu->id;
        $this->nom = $lieu->nom;
        $this->adresse = $lieu->adresse;
        $this->nb_places_assises = $lieu->nb_places_assises;
        $this->nb_places_debout = $lieu->nb_places_debout;
        $this->lien_image = $lieu->lien_image;
    }
}