<?php
namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Utilisateur\Utilisateur;
use nrv\core\repositoryInterfaces\UtilisateurRepositoryInterface;
use PDO;

class UserRepository implements UtilisateurRepositoryInterface{
    
    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }

    public function getUtilisateurs(): array{
        return $this->pdo->query('SELECT * FROM utilisateur')->fetchAll();
    }

    public function getUtilisateurByEmail(string $email): Utilisateur{
        $result = $this->pdo->query('SELECT * FROM utilisateur WHERE email = ' . $email)->fetch();
        return new Utilisateur($result['email'], $result['nom'], $result['prenom'], $result['password']);
    }

    public function save(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('INSERT INTO utilisateur (email, nom, prenom, password) VALUES (:email, :nom, :prenom, :password) ON CONFLICT (email) DO UPDATE SET nom = :nom, prenom = :prenom, password = :password');
        $request->execute([
            'nom' => $utilisateur->nom,
            'prenom' => $utilisateur->prenom,
            'email' => $utilisateur->email,
            'password' => $utilisateur->password
        ]);
    }

    public function updateUtilisateur(Utilisateur $utilisateur): void{
        $request = $this->pdo->prepare('UPDATE utilisateur SET nom = :nom, prenom = :prenom, password = :password WHERE email = :email');
        $request->execute([
            'nom' => $utilisateur->nom,
            'prenom' => $utilisateur->prenom,
            'email' => $utilisateur->email,
            'password' => $utilisateur->password
        ]);
    }

    public function deleteUtilisateur(string $email): void{
        $request = $this->pdo->prepare('DELETE FROM utilisateur WHERE email = :email');
        $request->execute(['email' => $email]);
    }

}