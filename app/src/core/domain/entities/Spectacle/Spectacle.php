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
    protected array $url_image;
    protected array $artistes;

    public function __construct(string $id, string $titre, string $description, string $url_video, array $url_image, array $artistes){
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->url_video = $url_video;
        $this->url_image = $url_image;
        $this->artistes = $artistes;
    }

    public function toDTO(): SpectacleDTO{
        return new SpectacleDTO($this);
    }

    public function getTitre(): string{
        return $this->titre;
    }

    public function getDescription(): string{
        return $this->description;
    }

    public function geturl_Video(): string{
        return $this->url_video;
    }

    public function geturl_Image(): array{
        return $this->url_image;
    }

    public function getDate(): DateTime{
        return $this->date;
    }

    public function getArtistes(): array{
        return $this->artistes;
    }
}