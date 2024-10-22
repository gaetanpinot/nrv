<?php
namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Utilisateur\Utilisateur;
use nrv\core\repositoryInterfaces\UtilisateurRepositoryInterface;
use PDO;

class UtilisateurRepository implements UtilisateurRepositoryInterface{
    
    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getUtilisateurs(): array{
        $result = $this->pdo->query('SELECT * FROM utilisateur')->fetchAll();
        $utilisateurs = [];
        foreach($result as $row){
            $utilisateurs[] = new Utilisateur($row['id'], $row['email'], $row['nom'], $row['prenom'], $row['password']);
        }
        return $utilisateurs;
    }

    public function getUtilisateurByEmail(string $email): Utilisateur{
        $request = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $request->execute(['email' => $email]);
        $request = $request->fetch();
        return new Utilisateur($request['id'], $request['email'], $request['nom'], $request['prenom'], $request['password']);
    }

    public function save(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('INSERT INTO utilisateur (id, email, nom, prenom, password) VALUES (:id, :email, :nom, :prenom, :password) ON CONFLICT (id) DO UPDATE SET email = :email, nom = :nom, prenom = :prenom, password = :password');
        $request->execute([
            'id' => $utilisateur->id,
            'nom' => $utilisateur->nom,
            'prenom' => $utilisateur->prenom,
            'email' => $utilisateur->email,
            'password' => $utilisateur->password
        ]);
        $request = $request->fetch();
    }

    public function updateUtilisateur(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('UPDATE utilisateur SET email= :email nom = :nom, prenom = :prenom, password = :password WHERE id = :id');
        $request->execute([
            'id' => $utilisateur->id,
            'nom' => $utilisateur->nom,
            'prenom' => $utilisateur->prenom,
            'email' => $utilisateur->email,
            'password' => $utilisateur->password
        ]);
        $request = $request->fetch();
    }

    public function deleteUtilisateur(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('DELETE FROM utilisateur WHERE id = :id');
        $request->execute(['id' => $utilisateur->id]);
        $request = $request->fetch();
    }

}