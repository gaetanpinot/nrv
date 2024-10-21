<?php
namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Lieu\Lieu;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\repositoryInterfaces\LieuRepositoryInterface;
use PDO;
use Respect\Validation\Rules\Contains;

class LieuRepository implements LieuRepositoryInterface{

    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getLieux(): array{
        return $this->pdo->query('SELECT * FROM lieu_spectacle')->fetchAll();
    }

    public function getLieuById(string $id): Lieu{
        $result = $this->pdo->query('SELECT * FROM lieu_spectacle WHERE id = ' . $id)->fetch();
        return new Lieu($result['id'], $result['nom'], $result['adresse'], $result['nb_places_assises'], $result['nb_places_debout'], $result['url_image']);
    }

    public function getLieuBySoiree(Soiree $soiree): Lieu{
        $result = $this->pdo->query('SELECT * FROM lieu_spectacle WHERE id = ' . $soiree->id_lieu)->fetch();
        return new Lieu($result['id'], $result['nom'], $result['adresse'], $result['nb_places_assises'], $result['nb_places_debout'], $result['url_image']);
    }

    public function save(Lieu $lieu): void{
        $request = $this->pdo->prepare('INSERT INTO lieu_spectacle (id, nom, adresse, nb_places_assises, nb_places_debout, url_image) VALUES (:id, :nom, :adresse, :nb_places_assises, :nb_places_debout, :url_image) ON CONFLICT (id) DO UPDATE SET nom = :nom, adresse = :adresse, nb_places_assises = :nb_places_assises, nb_places_debout = :nb_places_debout, url_image = :url_image');
        $request->execute([
            'id' => $lieu->id,
            'nom' => $lieu->nom,
            'adresse' => $lieu->adresse,
            'nb_places_assises' => $lieu->nb_places_assises,
            'nb_places_debout' => $lieu->nb_places_debout,
            'url_image' => $lieu->url_image
        ]);
    }

    public function updateLieu(Lieu $lieu): void{
        $request = $this->pdo->prepare('UPDATE lieu_spectacle SET nom = :nom, adresse = :adresse, nb_places_assises = :nb_places_assises, nb_places_debout = :nb_places_debout, url_image = :url_image WHERE id = :id');
        $request->execute([
            'id' => $lieu->id,
            'nom' => $lieu->nom,
            'adresse' => $lieu->adresse,
            'nb_places_assises' => $lieu->nb_places_assises,
            'nb_places_debout' => $lieu->nb_places_debout,
            'url_image' => $lieu->url_image
        ]);
    }

    public function deleteLieu(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM lieu_spectacle WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}