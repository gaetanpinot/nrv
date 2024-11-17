<?php

namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\domain\entities\Billet\Billet;
use nrv\core\domain\entities\Lieu\Lieu;
use nrv\core\domain\entities\Panier\Panier;
use nrv\core\domain\entities\Soiree\Soiree;
use nrv\core\domain\entities\Theme\Theme;
use nrv\core\repositoryInterfaces\ArtisteRepositoryInterface;
use nrv\core\repositoryInterfaces\BilletRepositoryInterface;
use nrv\core\repositoryInterfaces\PanierRepositoryInterface;
use PDO;
use Ramsey\Uuid\Uuid;

class PanierRepository implements PanierRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }
    public function getPanier(): array
    {
        return $this->pdo->query('SELECT * FROM panier')->fetchAll();
    }

    public function getPanierById(string $id): ?Panier
    {
        $stmt = $this->pdo->prepare('SELECT * FROM panier WHERE id = :id');

        $stmt->execute(['id' => $id]);

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }
        return new Panier($result['id'], $result['id_utilisateur'], $result['is_valide']);

    }

    public function save(Panier $panier): void
    {
        $request = $this->pdo->prepare('
        INSERT INTO panier (id, id_utilisateur, is_valide) 
        VALUES (:id, :id_utilisateur, :is_valide) 
        ON CONFLICT (id) DO UPDATE 
        SET id_utilisateur = :id_utilisateur, is_valide = :is_valide
                            
    ');
        $isValide = "0";
        $request->execute([
            'id' => $panier->id,
            'id_utilisateur' => $panier->id_utilisateur,
            'is_valide' => $isValide,
        ]);
        $request->fetch();

        $request->fetch();
    }


    public function updatePanier(Panier $panier): void
    {
        $request = $this->pdo->prepare('UPDATE panier SET id_utilisateur = :id_utilisateur, is_valide = :is_valide WHERE id = :id');
        $request->execute([
            'id' => $panier->id,
            'id_utilisateur' => $panier->id_utilisateur,
            'is_valide' => $panier->is_valide,
        ]);
    }

    public function deletePanier(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM panier WHERE id = :id');
        $request->execute(['id' => $id]);
    }

    public function getPanierByIdUtilisateur(string $id_utilisateur): ?Panier
    {
        $stmt = $this->pdo->prepare('SELECT * FROM panier WHERE id_utilisateur = :id_utilisateur');

        $stmt->execute(['id_utilisateur' => $id_utilisateur]);

        $result = $stmt->fetch();

        if (!$result) {
            return null;
        }
        return new Panier($result['id'], $result['id_utilisateur'], $result['is_valide']);

    }

    public function getPanierBilletsByUserId(string $id): array
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
            panier.is_valide = false;';
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
