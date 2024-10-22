<?php
namespace nrv\core\dto;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\core\dto\DTO;
use DateTime;

class SpectacleDTO extends DTO{

    public string $id;
    public string $titre;
    public string $description;
    public string $url_video;
    public string $url_image;
    public array  $artistes;

    public function __construct(Spectacle $spectacle){
        $this->id = $spectacle->id;
        $this->titre = $spectacle->titre;
        $this->description = $spectacle->description;
        $this->url_video = $spectacle->url_video;
        $this->url_image = $spectacle->url_image;
        $this->artistes = 
        array_map(function (Artiste $a){
            return new ArtisteDTO($a);
        },$spectacle->artistes);   
        
    }
}
