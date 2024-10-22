<?php
namespace nrv\infrastructure\Repositories;

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
            $soirees[] = new Soiree($soiree['id'], $soiree['nom'], $soiree['id_theme'], $soiree['date'], $soiree['heure_debut'], $soiree['duree'], $soiree['id_lieu'], $soiree['nb_places'], $soiree['nb_places_restantes'], $soiree['tarif_normal'], $soiree['tarif_reduit']);
        }
        return $soirees;
    }

    public function getSoireeById(string $id): Soiree{
        $request = $this->pdo->prepare('SELECT * FROM soiree WHERE id = :id');

        $request->execute(['id' => $id]);
        var_dump($request);
        return new Soiree($request['id'], $request['nom'], $request['id_theme'], $request['date'], $request['heure_debut'], $request['duree'], $request['id_lieu'], $request['nb_places'], $request['nb_places_restantes'], $request['tarif_normal'], $request['tarif_reduit']);
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
    }

    public function deleteSoiree(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM soiree WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}