<?php
namespace nrv\core\domain\entities\Spectacle;

use nrv\core\dto\SpectacleDTO;
use nrv\core\domain\entities\Entity;
use DateTime;

class Spectacle extends Entity{
    
    protected string $id;
    protected string $titre;
    protected string $description;
    protected string $url_video;
    protected string $url_image;
    protected array $artistes;
    protected array $dates;

    public function __construct(string $id, string $titre, string $description, string $url_video, string $url_image, array $artistes, array $dates = []){
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->url_video = $url_video;
        $this->url_image = $url_image;
        $this->artistes = $artistes;
        $this->dates = $dates;
    }

    public function toDTO(): SpectacleDTO{
        return new SpectacleDTO($this);
    }
}
