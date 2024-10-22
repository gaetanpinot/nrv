<?php
namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Spectacle\Spectacle;
use \PDO;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use DI\Container;
use nrv\core\domain\entities\Artiste\Artiste;

class SpectacleRepository implements SpectacleRepositoryInterface{

    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getSpectacles(): array{
        $result = $this->pdo->query('SELECT * FROM spectacle')->fetchAll();
        $spectacles = [];
        foreach($result as $spectacle){
            $artistes_prep = $this->pdo->prepare('SELECT id_artiste FROM spectacle_artistes WHERE id_spectacle = :spectacle_id');
            $artistes_prep->execute(['spectacle_id' => $spectacle['id']]);
            $artistes = [];
            foreach($artistes_prep as $artiste){
                $artiste_req = $this->pdo->prepare('SELECT * FROM artiste WHERE id = :id');
                $artiste_req->execute(['id' => $artiste['id_artiste']]);
                $artistes[] = new Artiste($artiste_req['id'], $artiste_req['prenom']);
            }
            $spectacles[] = new Spectacle($spectacle['id'], $spectacle['titre'], $spectacle['description'], $spectacle['url_video'], $spectacle['url_image'], $artistes);
        }
        return $spectacles;
    }


    public function test(){
        $result = $this->pdo->query('SELECT spectacle.id as spectacle_id, 
                                                spectacle.titre, 
                                                spectacle.description, 
                                                spectacle.url_video, 
                                                spectacle.url_image,
                                                json_agg(json_build_object(\'id\', artiste.id, \'prenom\', artiste.prenom)) as artistes
                                                FROM spectacle 
                                                    INNER JOIN spectacle_artistes ON spectacle.id=spectacle_artistes.id_spectacle
                                                    INNER JOIN artiste ON spectacle_artistes.id_artiste=artiste.id
                                                GROUP BY spectacle_id')->fetchAll();
        var_dump($result);
    }

    public function getSpectacleById(string $id): Spectacle{
        $result = $this->pdo->prepare('SELECT * FROM spectacle WHERE id = :id');
        $result->execute(['id' => $id]);
        $artistes_prep = $this->pdo->prepare('SELECT id_artiste FROM spectacle_artistes WHERE id_spectacle = :spectacle_id');
        $artistes_prep->execute(['spectacle_id' => $result['id_artiste']]);
        $artistes = [];
        foreach($artistes_prep as $artiste){
            $artiste_req = $this->pdo->prepare('SELECT * FROM artiste WHERE id = :id');
            $artiste_req->execute(['id' => $artiste['id']]);
            $artistes[] = new Artiste($artiste_req['id'], $artiste_req['prenom']);
        }
        return new Spectacle($result['id'], $result['titre'], $result['description'], $result['url_url_video'], $result['url_image'], $artistes);
    }

    public function save(Spectacle $spectacle): void{
        $request = $this->pdo->prepare('INSERT INTO spectacle (id, titre, description, url_video, url_image, date) VALUES (:id, :titre, :description, :url_video, :url_image) ON CONFLICT (id) DO UPDATE SET titre = :titre, description = :description, url_video = :url_video, url_image = :url_image');
        $request->execute([
            'id' => $spectacle->id,
            'titre' => $spectacle->titre,
            'description' => $spectacle->description,
            'url_video' => $spectacle->url_video,
            'url_image' => $spectacle->url_image
        ]);
    }

    public function updateSpectacle(Spectacle $spectacle): void{
        $request = $this->pdo->prepare('UPDATE spectacle SET titre = :titre, description = :description, url_video = :url_video, url_image = :url_image WHERE id = :id');
        $request->execute([
            'id' => $spectacle->id,
            'titre' => $spectacle->titre,
            'description' => $spectacle->description,
            'url_video' => $spectacle->url_video,
            'url_image' => $spectacle->url_image
        ]);
    }

    public function deleteSpectacle(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM spectacle WHERE id = :id');
        $request->execute(['id' => $id]);
        $request = $this->pdo->prepare('DELETE FROM spectacle_artistes WHERE id_spectacle = :id');
        $request->execute(['id' => $id]);
    }
}