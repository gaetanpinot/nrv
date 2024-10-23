<?php
namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Lieu\Lieu;
use nrv\core\domain\entities\Spectacle\Spectacle;
use nrv\core\repositoryInterfaces\SoireeRepositoryInterface;
use DI\Container;
use nrv\core\domain\entities\Soiree\Soiree;
use PDO;

class SoireeRepository implements SoireeRepositoryInterface{

    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getSoirees(): array{
        $result = $this->pdo->query('SELECT * FROM soiree')->fetchAll();
        $soirees = [];
        foreach($result as $soiree){
            $soirees[] = new Soiree($soiree['id'], $soiree['nom'], $soiree['id_theme'], $soiree['date'], $soiree['heure_debut'], $soiree['duree'], $soiree['id_lieu'], $soiree['nb_places_assises_restantes'], $soiree['nb_places_debout_restantes'], $soiree['tarif_normal'], $soiree['tarif_reduit']);
        }
        return $soirees;
    }

    public function getSoireeById(string $id): Soiree{
        $request = $this->pdo->prepare("SELECT soiree.*,
                                                json_agg(json_build_object('id', spectacle.id, 'titre', spectacle.titre, 'description', spectacle.description, 'url_image', spectacle.url_image, 'url_video', spectacle.url_video, 
                                                    'artistes', (
                                                                   SELECT json_agg(json_build_object(
                                                                       'id', artiste.id, 
                                                                       'prenom', artiste.prenom
                                                                   ))
                                                                   FROM artiste
                                                                   INNER JOIN spectacle_artistes ON artiste.id = spectacle_artistes.id_artiste
                                                                   WHERE spectacle_artistes.id_spectacle = spectacle.id
                                                                   )
                                                    )) as spectacle,
                                                json_build_object('id', lieu_spectacle.id, 'nom', lieu_spectacle.nom, 'adresse', lieu_spectacle.adresse, 'nb_places_assises', lieu_spectacle.nb_places_assises, 'nb_places_debout', lieu_spectacle.nb_places_debout, 'lien_image', lieu_spectacle.lien_image) as lieu
                                                FROM soiree,
                                                spectacles_soiree,
                                                spectacle,
                                                spectacle_artistes,
                                                artiste,
                                                lieu_spectacle
                                                WHERE 
                                                soiree.id = spectacles_soiree.id_soiree and
                                                spectacle.id = spectacles_soiree.id_spectacle and
                                                spectacle.id = spectacle_artistes.id_spectacle and
                                                artiste.id = spectacle_artistes.id_artiste and
                                                soiree.id_lieu = lieu_spectacle.id
                                                                                                
                                                GROUP BY soiree.id, spectacle.id, lieu_spectacle.id
                                                HAVING soiree.id = :id;");

        $request->execute(['id' => $id]);
        $soiree = $request->fetch();

        $lieu_decodee = json_decode($soiree['lieu'],true);
        $lieu = new Lieu($lieu_decodee['id'], $lieu_decodee['nom'], $lieu_decodee['adresse'], $lieu_decodee['nb_places_assises'], $lieu_decodee['nb_places_debout'], $lieu_decodee['lien_image']);

        $spectacles = array();
        $spectacles_decodee = json_decode($soiree['spectacle'], true);
        foreach ($spectacles_decodee as $spec) {
            $artistes = array();
            foreach ($spec['artistes'] as $artiste) {
                $artistes[] = new Artiste($artiste['id'], $artiste['prenom']);
            }

            $spectacles[] = new Spectacle($spec['id'], $spec['titre'], $spec['description'], $spec['url_video'], $spec['url_image'], $artistes);
        }

        $retour = new Soiree($soiree['id'], $soiree['nom'], $soiree['id_theme'], $soiree['date'], $soiree['heure_debut'], $soiree['duree'], $lieu, $spectacles,
            $soiree['nb_places_assises_restantes'], $soiree['nb_places_debout_restantes'], $soiree['tarif_normal'], $soiree['tarif_reduit']);


        return $retour;
    }

    public function save(Soiree $soiree): void{
        $request = $this->pdo->prepare('INSERT INTO soiree (id, nom, id_theme, date, heure_debut, duree, id_lieu, nb_places_assises_restante, nb_places_debout_restantes, tarif_normal, tarif_reduit) VALUES (:id, :nom, :id_theme, :date, :heure_debut, :duree, :id_lieu, :nb_places, :nb_places_assises_restantes, :nb_places_debout_restantes, :tarif_normal, :tarif_reduit) ON CONFLICT (id) DO UPDATE SET nom = :nom, id_theme = :id_theme, date = :date, heure_debut = :heure_debut, duree = :duree, id_lieu = :id_lieu, nb_places_assises_restantes = :nb_places_assises_restantes, nb_places_debout_restantes = :nb_places_debout_restantes, tarif_normal = :tarif_normal, tarif_reduit = :tarif_reduit');
        $request->execute([
            'id' => $soiree->id,
            'nom' => $soiree->nom,
            'id_theme' => $soiree->id_theme,
            'date' => $soiree->date,
            'heure_debut' => $soiree->heure_debut,
            'duree' => $soiree->duree,
            'id_lieu' => $soiree->id_lieu,
            'nb_places_assises_restantes' => $soiree->nb_places_assises_restantes,
            'nb_places_debout_restantes' => $soiree->nb_places_debout_restantes,
            'tarif_normal' => $soiree->tarif_normal,
            'tarif_reduit' => $soiree->tarif_reduit
        ]);
        $request = $request->fetch();
    }

    public function updateSoiree(Soiree $soiree): void{
        $request = $this->pdo->prepare('UPDATE soiree SET nom = :nom, id_theme = :id_theme, date = :date, heure_debut = :heure_debut, duree = :duree, id_lieu = :id_lieu, nb_places_assises_restante = :nb_places_assises_restantes, nb_places_debout_restantes = :nb_places_debout_restantes, tarif_normal = :tarif_normal, tarif_reduit = :tarif_reduit WHERE id = :id');
        $request->execute([
            'id' => $soiree->id,
            'nom' => $soiree->nom,
            'id_theme' => $soiree->id_theme,
            'date' => $soiree->date,
            'heure_debut' => $soiree->heure_debut,
            'duree' => $soiree->duree,
            'id_lieu' => $soiree->id_lieu,
            'nb_places_assises_restantes' => $soiree->nb_places_assises_restantes,
            'nb_places_debout_restantes' => $soiree->nb_places_debout_restantes,
            'tarif_normal' => $soiree->tarif_normal,
            'tarif_reduit' => $soiree->tarif_reduit
        ]);
        $request = $request->fetch();
    }

    public function deleteSoiree(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM soiree WHERE id = :id');
        $request->execute(['id' => $id]);
        $request = $request->fetch();
    }
}
