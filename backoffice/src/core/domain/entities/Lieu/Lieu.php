<?php
namespace nrv\back\core\domain\entities\Lieu;

use nrv\back\core\dto\LieuDTO;
use nrv\back\core\domain\entities\Entity;

class Lieu extends Entity{

    protected string $id;
    protected string|null $nom;
    protected string|null $adresse;
    protected string|null $nb_places_assises;
    protected string|null $nb_places_debout;
    protected array|null $lien_image;

    public function __construct(string $id, string|null $nom, string|null $adresse, string|null $nb_places_assises, string|null $nb_places_debout, array|null $lien_image){
        $this->id = $id;
        $this->nom = $nom;
        $this->adresse = $adresse;
        $this->nb_places_assises = $nb_places_assises;
        $this->nb_places_debout = $nb_places_debout;
        $this->lien_image = $lien_image;
    }

    public function toDTO(): LieuDTO{
        return new LieuDTO($this);
    }
}
