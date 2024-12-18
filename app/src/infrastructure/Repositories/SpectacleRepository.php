<?php
namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Spectacle\Spectacle;
use \PDO;
use nrv\core\repositoryInterfaces\SpectacleRepositoryInterface;
use DI\Container;
use \DateTime;

class SpectacleRepository implements SpectacleRepositoryInterface{

    protected PDO $pdo;
    protected string $formaDate;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
        $this->formaDate = $cont->get('date.format');
    }

    public function getSpectacles(int $offset = 0, int $nombre = 12, array $filtre = null): array{
        //on veut un spectacle et tous ses artistes en une seul requete
        //on ne veut pas à avoir plusieurs lignes avec le meme id de spectacle pour les differents artistes
        //on fait le select avec un group by sur la table principale
        //dans le select on construit un object json avec les elements de la table secondaire
        //puis les concatennes tous avec json_agg
        $tables = '';
        $where = '';
        $order = '';
        $decalage = $offset * $nombre;
        $execute = array('limit'=>$nombre,
        'offset'=> $decalage);

        if($filtre != null){
            if(isset($filtre['date']) && $filtre['date'] != null && $filtre['date']['sens'] != 'all'){
                $where .= ' ';
                $order = ' order by soiree.date '.$filtre['date']['sens'].' ';
            }
            if(isset($filtre['style']) && $filtre['style']['label'] != null && $filtre['style']['label'] != 'all'){
                $tables .= 'theme,';
                $where .= ' soiree.id_theme = theme.id and
                    theme.label = :style and ';
                $execute = array_merge(array('style' => $filtre['style']['label']), $execute);
            }
            if(isset($filtre['lieu']) && $filtre['lieu']['nom'] != null && $filtre['lieu']['nom'] != 'all'){
                $tables .= 'lieu_spectacle,';
                $where .= ' soiree.id_lieu = lieu_spectacle.id and
                    lieu_spectacle.nom = :lieu and ';
                $execute = array_merge(array('lieu' => $filtre['lieu']['nom']), $execute);
            }
            $query = "
            select
            spectacle.*,
            json_agg(soiree.date) as dates
            from spectacle,".$tables.
            "spectacles_soiree,
            soiree
            where".$where.
            " spectacle.id = spectacles_soiree.id_spectacle and
            spectacles_soiree.id_soiree = soiree.id
            group by spectacle.id, soiree.date".$order."
            limit :limit
            offset :offset 
            ;";
        }else{
            $query = "
            select
            spectacle.*,
            json_agg(soiree.date) as dates
            from spectacle,
            soiree,
            spectacles_soiree
            where 
            spectacle.id = spectacles_soiree.id_spectacle and
            spectacles_soiree.id_soiree = soiree.id
            group by spectacle.id
            limit :limit
            offset :offset 
            ;";
        }

        $request = $this->pdo->prepare($query);
        $request->execute($execute);
        $spectacles = $request->fetchAll();
        $retour = [];

        //on a plusieur spectacle
        foreach($spectacles as $spectacle){

            //on récupère les multiples artistes des spectacles
            $query = "select artiste.id, artiste.prenom from spectacle_artistes, artiste 
                where spectacle_artistes.id_spectacle = :id and artiste.id = spectacle_artistes.id_artiste";
            $request = $this->pdo->prepare($query);
            $request->execute(['id' => $spectacle['id']]);
            $artistes = $request->fetchAll();
            $artistes_decodee=[];

            //on créer une entité pour chaque artiste du spectacle
            foreach($artistes as $artiste) {
                $artistes_decodee[] = new Artiste($artiste['id'], $artiste['prenom']);
            }

            //on decodes les multiples artistes des spectacles
            $dates = json_decode($spectacle['dates'],true);
            $dates_decodee=[];

            //on créer une entité pour chaque artiste du spectacle
            foreach($dates as $date) {
                $dates_decodee[] = DateTime::createFromFormat($this->formaDate, $date) ;
            }
            //on l'ajoute au spectacle
            $retour[] = new Spectacle($spectacle['id'],
                $spectacle['titre'],
                $spectacle['description'],
                $spectacle['url_video'],
                $spectacle['url_image'],
                $artistes_decodee,
                $dates_decodee);
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
