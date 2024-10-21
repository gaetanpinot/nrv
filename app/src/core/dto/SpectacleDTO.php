<?php
namespace nrv\core\dto;

use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\core\dto\DTO;
use DateTime;

class SpectacleDTO extends DTO{

    public string $id;
    public string $titre;
    public string $description;
    public string $video;
    public array $images;
    public DateTime $date;
    public array $artistes;

    public function __construct(Spectacle $spectacle){
        $this->id = $spectacle->getId();
        $this->titre = $spectacle->getTitre();
        $this->description = $spectacle->getDescription();
        $this->video = $spectacle->getVideo();
        $this->images = $spectacle->getImages();
        $this->date = $spectacle->getDate();
        $this->artistes = $spectacle->getArtistes();
    }
}