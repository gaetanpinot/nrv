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
            $utilisateurs[] = new Utilisateur($row['id'], $row['email'], $row['nom'], $row['prenom'], $row['password'], $row['role']);
        }
        return $utilisateurs;
    }

    public function getUtilisateurByEmail(string $email): Utilisateur {
        $request = $this->pdo->prepare('SELECT * FROM utilisateur WHERE email = :email');
        $request->execute(['email' => $email]);

        $result = $request->fetch();

        if (!$result) {
            throw new \Exception("Utilisateur avec l'email {$email} non trouve.");
        }

        return new Utilisateur($result['id'], $result['email'], $result['nom'], $result['prenom'], $result['password'], $result['role']);
    }


    public function save(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('INSERT INTO utilisateur (id, email, nom, prenom, password, role) VALUES (:id, :email, :nom, :prenom, :password, :role) ON CONFLICT (id) DO UPDATE SET email = :email, nom = :nom, prenom = :prenom, password = :password, role = :role');
        $request->execute([
            'id' => $utilisateur->id,
            'nom' => $utilisateur->nom,
            'prenom' => $utilisateur->prenom,
            'email' => $utilisateur->email,
            'password' => $utilisateur->password,
            'role' => $utilisateur->role
        ]);
    }

    public function updateUtilisateur(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('UPDATE utilisateur SET email = :email nom = :nom, prenom = :prenom, password = :password, role = :role WHERE id = :id');
        $request->execute([
            'id' => $utilisateur->id,
            'nom' => $utilisateur->nom,
            'prenom' => $utilisateur->prenom,
            'email' => $utilisateur->email,
            'password' => $utilisateur->password,
            'role' => $utilisateur->role
        ]);
    }

    public function deleteUtilisateur(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('DELETE FROM utilisateur WHERE id = :id');
        $request->execute(['id' => $utilisateur->id]);
    }

}