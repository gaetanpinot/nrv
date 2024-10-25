<?php
namespace nrv\back\infrastructure\Repositories;

use DI\Container;
use nrv\back\core\domain\entities\Lieu\Lieu;
use nrv\back\core\domain\entities\Soiree\Soiree;
use nrv\back\core\repositoryInterfaces\LieuRepositoryInterface;
use PDO;
use Respect\Validation\Rules\Contains;

class LieuRepository implements LieuRepositoryInterface{

    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getLieux(): array{
        $result = $this->pdo->query("SELECT *,json_build_object('lien_images', lieu_spectacle.lien_image) as lien_images FROM lieu_spectacle")->fetchAll();
        $lieux = [];
        foreach($result as $lieu){
            $lieux[] = new Lieu($lieu['id'], $lieu['nom'], $lieu['adresse'], $lieu['nb_places_assises'], $lieu['nb_places_debout'], json_decode($lieu['lien_images'],true));
        }
        return $lieux;
    }

    public function getLieuById(string $id): Lieu{
        $result = $this->pdo->query('SELECT * FROM lieu_spectacle WHERE id = :id');
        $result->execute(['id' => $id]);
        $result = $result->fetch();
        return new Lieu($result['id'], $result['nom'], $result['adresse'], $result['nb_places_assises'], $result['nb_places_debout'], $result['lien_image']);
    }

    public function getLieuBySoiree(Soiree $soiree): Lieu{
        $result = $this->pdo->query('SELECT * FROM lieu_spectacle WHERE id = :id_lieu');
        $result->execute(['id_lieu' => $soiree->id_lieu]);
        $result = $result->fetch();
        return new Lieu($result['id'], $result['nom'], $result['adresse'], $result['nb_places_assises'], $result['nb_places_debout'], $result['lien_image']);
    }

    public function save(Lieu $lieu): void{
        $request = $this->pdo->prepare('INSERT INTO lieu_spectacle (id, nom, adresse, nb_places_assises, nb_places_debout, lien_image) VALUES (:id, :nom, :adresse, :nb_places_assises, :nb_places_debout, :lien_image) ON CONFLICT (id) DO UPDATE SET nom = :nom, adresse = :adresse, nb_places_assises = :nb_places_assises, nb_places_debout = :nb_places_debout, lien_image = :lien_image');
        $request->execute([
            'id' => $lieu->id,
            'nom' => $lieu->nom,
            'adresse' => $lieu->adresse,
            'nb_places_assises' => $lieu->nb_places_assises,
            'nb_places_debout' => $lieu->nb_places_debout,
            'lien_image' => $lieu->lien_image
        ]);
        $request = $request->fetch();
    }

    public function updateLieu(Lieu $lieu): void{
        $request = $this->pdo->prepare('UPDATE lieu_spectacle SET nom = :nom, adresse = :adresse, nb_places_assises = :nb_places_assises, nb_places_debout = :nb_places_debout, lien_image = :lien_image WHERE id = :id');
        $request->execute([
            'id' => $lieu->id,
            'nom' => $lieu->nom,
            'adresse' => $lieu->adresse,
            'nb_places_assises' => $lieu->nb_places_assises,
            'nb_places_debout' => $lieu->nb_places_debout,
            'lien_image' => $lieu->lien_image
        ]);
        $request = $request->fetch();
    }

    public function deleteLieu(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM lieu_spectacle WHERE id = :id');
        $request->execute(['id' => $id]);
        $request = $request->fetch();
    }
}
