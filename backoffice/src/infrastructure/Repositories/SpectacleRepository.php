<?php
namespace nrv\back\infrastructure\Repositories;

use nrv\back\core\domain\entities\Artiste\Artiste;
use nrv\back\core\domain\entities\Spectacle\Spectacle;
use \PDO;
use nrv\back\core\repositoryInterfaces\SpectacleRepositoryInterface;
use DI\Container;
use \DateTime;

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
        spectacle.id = :spectacle.id and
        spectacle.id = spectacle_artistes.id_spectacle and
        artiste.id = spectacle_artistes.id_artiste
        group by spectacle.id
        ;";

        $request = $this->pdo->prepare($query);
        $request->execute(['spectacle.id' => $id]);
        $spectacle = $request->fetchAll();

        //on decodes les multiples artistes des spectacles
        $artistes = json_decode($spectacle['artistes'],true);
        $artistes_decodee=[];

        //on créer une entité pour chaque artiste du spectacle
        foreach($artistes as $artiste) {
            $artistes_decodee[] = new Artiste($artiste['id'], $artiste['prenom']);
        }

        //on l'ajoute au spectacle
        $retour = new Spectacle($spectacle['id'],
            $spectacle['titre'],
            $spectacle['description'],
            $spectacle['url_video'],
            $spectacle['url_image'],
            $artistes_decodee);
        return $retour;
    }

    public function getSpectaclesByDate($dateDebut, $dateFin): array{
        //on veut les spectacles compris entre deux dates et tous ses artistes en une seul requete
        //on ne veut pas à avoir plusieurs lignes avec le meme id de spectacle pour les differents artistes
        //on fait le select avec un group by sur la table principale
        //dans le select on construit un object json avec les elements de la table secondaire
        //puis les concatennes tous avec json_agg

        //vérifier que les dates sont bien des dates au format YYYY-MM-DD sinon lever une erreur
        if (!DateTime::createFromFormat('Y-m-d', $dateDebut) || !DateTime::createFromFormat('Y-m-d', $dateFin)){
            throw new \Exception('Les dates ne sont pas au bon format');
        }

        $query = "
        select
        spectacle.*,
        json_agg(json_build_object('id', artiste.id, 'prenom', artiste.prenom)) as artistes
        from spectacle,
        spectacle_artistes,
        artiste,
        soiree,
        spectacles_soiree
        where
        soiree.date between :dateDebut and :dateFin and
        soiree.id = spectacles_soiree.id_soiree and
        spectacle.id = spectacles_soiree.id_spectacle and
        spectacle.id = spectacle_artistes.id_spectacle and
        artiste.id = spectacle_artistes.id_artiste
        group by spectacle.id
        ;";

        $request = $this->pdo->prepare($query);
        $request->execute(['dateDebut' => $dateDebut, 'dateFin' => $dateFin]);
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

    public function save(Spectacle $spectacle): void{
        $request = $this->pdo->prepare('INSERT INTO spectacle (id, titre, description, url_video, url_image ) VALUES (:id, :titre, :description, :url_video, :url_image) ON CONFLICT (id) DO UPDATE SET titre = :titre, description = :description, url_video = :url_video, url_image = :url_image');
        $request->execute([
            'id' => $spectacle->id,
            'titre' => $spectacle->titre,
            'description' => $spectacle->description,
            'url_video' => $spectacle->url_video,
            'url_image' => $spectacle->url_image
        ]);
        $request = $request->fetch();



//        echo "OKKKKKKKKKKKKKKKKK";
        foreach($spectacle->artistes as $artiste){
            $request = $this->pdo->prepare('INSERT INTO spectacle_artistes (id_spectacle, id_artiste) VALUES (:id_spectacle, :id_artiste) ON CONFLICT (id_spectacle, id_artiste) DO NOTHING');
            $request->execute([
                'id_spectacle' => $spectacle->id,
                'id_artiste' => $artiste
            ]);
            $request = $request->fetch();
        }
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
