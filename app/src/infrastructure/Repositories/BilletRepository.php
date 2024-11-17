<?php

namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Lieu\Lieu;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\domain\entities\Theme\Theme;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;
use nrv\infrastructure\Exceptions\NoDataFoundException;
use PDO;

class BilletRepository implements BilletRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(Container $cont)
    {
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getBillet(): array
    {
        return $this->pdo->query('SELECT * FROM billet')->fetchAll();
    }

    public function getBilletById(string $id): Billet
    {
        $stmt = $this->pdo->prepare('SELECT * FROM billet WHERE id = :id');

        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();

        if (!$result) {
            throw new NoDataFoundException("Billet non trouvé : $id");
        }

        return new Billet($result['id'], $result['id_utilisateur'], $result['id_soiree'], $result['tarif']);
    }

    public function save(Billet $billet): void
    {
        $request = $this->pdo->prepare('INSERT INTO billet (id, id_utilisateur, id_soiree, tarif) VALUES (:id, :id_utilisateur, :id_soiree, :tarif) ON CONFLICT (id) DO UPDATE SET id_utilisateur = :id_utilisateur, id_soiree = :id_soiree, tarif = :tarif');
        $request->execute([
            'id' => $billet->id,
            'id_utilisateur' => $billet->id_utilisateur,
            'id_soiree' => $billet->id_soiree,
            'tarif' => $billet->tarif,
        ]);
    }

    public function updateBillet(Billet $billet): void
    {
        $request = $this->pdo->prepare('UPDATE billet SET id_utilisateur = :id_utilisateur, id_spectacle = :id_soiree, tarif = :tarif WHERE id = :id');
        $request->execute([
            'id' => $billet->id,
            'id_utilisateur' => $billet->id_utilisateur,
            'id_soiree' => $billet->id_soiree,
            'tarif' => $billet->tarif,
        ]);
    }

    public function deleteBillet(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM billet WHERE id = :id');
        $request->execute(['id' => $id]);
    }

    public function getMesBillets(string $id): array
    {
$query = '
        select 
        billet.* ,
        soiree.*
        from 
            panier,
            billet_panier,
        billet,
        soiree
        where 
            panier.id = billet_panier.id_panier and
            billet.id = billet_panier.id_billet and
            panier.id_utilisateur = :id and
            soiree.id = billet.id_soiree and
            panier.is_valide = true;';
        try{
        $res = $this->pdo->prepare($query);
        $res->execute(['id' => $id]);
        $billets = $res->fetchAll(PDO::FETCH_ASSOC);

        $retour = array_map(function($b){
                $soiree = new Soiree($b['id_soiree'], $b['nom'], new Theme($b['id_theme'],""), $b['date'], $b['heure_debut'], $b['duree'], new Lieu('','','','','',[]), [],
                $b['nb_places_assises_restantes'], $b['nb_places_debout_restantes'], $b['tarif_normal'], $b['tarif_reduit']);
            return new Billet(
                $b['id'],
                $b['id_utilisateur'],
                    $soiree,
                $b['tarif']
            );
        },$billets);

        return $retour;
        }catch(\PDOException $e){
            throw new \Exception( $e->getMessage() );
        }
    }

}
