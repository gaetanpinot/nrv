<?php
namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Artiste\Artiste;
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
        //on veut un spectacle et tous ses artistes en une seul requete
        //on ne veut pas à avoir plusieurs lignes avec le meme id de spectacle pour les differents artistes
        //on fait le select avec un group by sur la table principale
        //dans le select on construit un object json avec les elements de la table secondaire
        //puis les concatennes tous avec json_agg
        $query = "
        select
        spectacle.*,
        json_agg(json_build_object('id', artiste.id, 'prenom', artiste.prenom)) as artistes
        from spectacle,
        spectacle_artistes,
        artiste
        where
        spectacle.id = spectacle_artistes.id_spectacle and
        artiste.id = spectacle_artistes.id_artiste
        group by spectacle.id
        ;";

        $request = $this->pdo->prepare($query);
        $request->execute([]);
        $spectacles = $request->fetchAll();
        $retour = [];

        //on a plusieur spectacle
        foreach($spectacles as $spectacle){

            //on decodes les multiples artistes des spectacles
            $artistes = json_decode($spectacle['artistes'],true);
            $artistes_decodee=[];

            //on créer une entité pour chaque artiste du spectacle
            foreach($artistes as $artiste) {
                $artistes_decodee[] = new Artiste($artiste['id'], $artiste['prenom']);
            }

            //on l'ajoute au spectacle
            $retour[] = new Spectacle($spectacle['id'],
                $spectacle['titre'],
                $spectacle['description'],
                $spectacle['url_video'],
                $spectacle['url_image'],
                $artistes_decodee);
        }
        return $retour;
    }

    public function getSpectacleById(string $id): Spectacle{
        $result = $this->pdo->prepare('SELECT * FROM spectacle WHERE id = :id');
        $result->execute(['id' => $id]);
        $result = $result->fetch();
        $artistes_prep = $this->pdo->prepare('SELECT id_artiste FROM spectacle_artistes WHERE id_spectacle = :spectacle_id');
        $artistes_prep->execute(['spectacle_id' => $result['id_artiste']]);
        $artistes_prep = $artistes_prep->fetchAll();
        $artistes = [];
        foreach($artistes_prep as $artiste){
            $artiste_req = $this->pdo->prepare('SELECT * FROM artiste WHERE id = :id');
            $artiste_req->execute(['id' => $artiste['id']]);
            $artiste_req = $artiste_req->fetch();
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
        $request = $request->fetch();
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
        $request->fetch();
    }

    public function deleteSpectacle(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM spectacle WHERE id = :id');
        $request->execute(['id' => $id]);
        $request = $request->fetch();
        $request = $this->pdo->prepare('DELETE FROM spectacle_artistes WHERE id_spectacle = :id');
        $request->execute(['id' => $id]);
        $request = $request->fetch();
    }
}
