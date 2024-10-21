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
        return $this->pdo->query('SELECT * FROM soiree')->fetchAll();
    }

    public function getSoireeById(string $id): Soiree{
        $result = $this->pdo->query('SELECT * FROM soiree WHERE id = ' . $id)->fetch();
        return new Soiree($result['id'], $result['nom'], $result['id_theme'], $result['date'], $result['heureDebut'], $result['duree'], $result['id_lieu'], $result['nbPlaceAssiseRestante'], $result['nbPlaceDeboutRestante'], $result['tarifNormal'], $result['tarifReduit']);
    }

    public function save(Soiree $soiree): void{
        $request = $this->pdo->prepare('INSERT INTO soiree (id, nom, id_theme, date, heureDebut, duree, id_lieu, nbPlaceAssiseRestante, nbPlaceDeboutRestante, tarifNormal, tarifReduit) VALUES (:id, :nom, :id_theme, :date, :heureDebut, :duree, :id_lieu, :nbPlaceAssiseRestante, :nbPlaceDeboutRestante, :tarifNormal, :tarifReduit) ON CONFLICT (id) DO UPDATE SET nom = :nom, id_theme = :id_theme, date = :date, heureDebut = :heureDebut, duree = :duree, id_lieu = :id_lieu, nbPlaceAssiseRestante = :nbPlaceAssiseRestante, nbPlaceDeboutRestante = :nbPlaceDeboutRestante, tarifNormal = :tarifNormal, tarifReduit = :tarifReduit');
        $request->execute([
            'id' => $soiree->id,
            'nom' => $soiree->nom,
            'id_theme' => $soiree->id_theme,
            'date' => $soiree->date,
            'heureDebut' => $soiree->heureDebut,
            'duree' => $soiree->duree,
            'id_lieu' => $soiree->id_lieu,
            'nbPlaceAssiseRestante' => $soiree->nbPlaceAssiseRestante,
            'nbPlaceDeboutRestante' => $soiree->nbPlaceDeboutRestante,
            'tarifNormal' => $soiree->tarifNormal,
            'tarifReduit' => $soiree->tarifReduit
        ]);
    }

    public function updateSoiree(Soiree $soiree): void{
        $request = $this->pdo->prepare('UPDATE soiree SET nom = :nom, id_theme = :id_theme, date = :date, heureDebut = :heureDebut, duree = :duree, id_lieu = :id_lieu, nbPlaceAssiseRestante = :nbPlaceAssiseRestante, nbPlaceDeboutRestante = :nbPlaceDeboutRestante, tarifNormal = :tarifNormal, tarifReduit = :tarifReduit WHERE id = :id');
        $request->execute([
            'id' => $soiree->id,
            'nom' => $soiree->nom,
            'id_theme' => $soiree->id_theme,
            'date' => $soiree->date,
            'heureDebut' => $soiree->heureDebut,
            'duree' => $soiree->duree,
            'id_lieu' => $soiree->id_lieu,
            'nbPlaceAssiseRestante' => $soiree->nbPlaceAssiseRestante,
            'nbPlaceDeboutRestante' => $soiree->nbPlaceDeboutRestante,
            'tarifNormal' => $soiree->tarifNormal,
            'tarifReduit' => $soiree->tarifReduit
        ]);
    }

    public function deleteSoiree(string $id): void{
        $request = $this->pdo->prepare('DELETE FROM soiree WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}