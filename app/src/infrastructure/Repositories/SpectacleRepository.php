<?php
namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Spectacle\Spectacle;
use \PDO;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use DI\Container;

class SpectacleRepository implements SpectacleRepositoryInterface{

    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getSpectacles(): array{
        return $this->pdo->query('SELECT * FROM spectacle')->fetchAll();
    }

    public function getSpectacleById(string $id): Spectacle{
        $result = $this->pdo->query('SELECT * FROM spectacle WHERE id = ' . $id)->fetch();
        return new Spectacle($result['id'], $result['titre'], $result['description'], $result['video'], $result['images'], $result['date'], $result['artistes']);
    }

    public function save(Spectacle $spectacle): void{
        $request = $this->pdo->prepare('INSERT INTO spectacle (id, titre, description, video, images, date, artistes) VALUES (:id, :titre, :description, :video, :images, :date, :artistes) ON CONFLICT (id) DO UPDATE SET titre = :titre, description = :description, video = :video, images = :images, date = :date, artistes = :artistes');
        $request->execute([
            'id' => $spectacle->id,
            'titre' => $spectacle->titre,
            'description' => $spectacle->description,
            'video' => $spectacle->video,
            'images' => $spectacle->images,
            'date' => $spectacle->date,
            'artistes' => $spectacle->artistes
        ]);
    }

    public function updateSpectacle(Spectacle $spectacle): void{
        $request = $this->pdo->prepare('UPDATE spectacle SET titre = :titre, description = :description, video = :video, images = :images, date = :date, artistes = :artistes WHERE id = :id');
        $request->execute([
            'id' => $spectacle->id,
            'titre' => $spectacle->titre,
            'description' => $spectacle->description,
            'video' => $spectacle->video,
            'images' => $spectacle->images,
            'date' => $spectacle->date,
            'artistes' => $spectacle->artistes
        ]);
    }

    public function deleteSpectacle(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM spectacle WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}