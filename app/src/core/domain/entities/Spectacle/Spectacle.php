<?php
namespace nrv\core\domain\entities\Spectacle;

use nrv\core\dto\SpectacleDTO;
use nrv\core\domain\entities\Entity;
use DateTime;

class Spectacle extends Entity{
    
    protected string $id;
    protected string $titre;
    protected string $description;
    protected string $video;
    protected array $images;
    protected DateTime $date;
    protected array $artistes;

    public function __construct(string $id, string $titre, string $description, string $video, array $images, DateTime $date, array $artistes){
        $this->id = $id;
        $this->titre = $titre;
        $this->description = $description;
        $this->video = $video;
        $this->images = $images;
        $this->date = $date;
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

    public function getVideo(): string{
        return $this->video;
    }

    public function getImages(): array{
        return $this->images;
    }

    public function getDate(): DateTime{
        return $this->date;
    }

    public function getArtistes(): array{
        return $this->artistes;
    }
}