<?php

namespace nrv\core\service\utilisateur;

use Firebase\JWT\JWT;
use nrv\core\domain\entities\Utilisateur\Utilisateur;
use nrv\core\dto\UtilisateurDTO;
use nrv\infrastructure\Repositories\UtilisateurRepository;
use Ramsey\Uuid\Uuid;

class UtilisateurService
{
    protected UtilisateurRepository $utilisateurRepository;
    protected string $secretKey;

    public function __construct(UtilisateurRepository $utilisateurRepository)
    {
        $this->utilisateurRepository = $utilisateurRepository;
        $this->secretKey = getenv('JWT_SECRET_KEY');
    }

    public function inscription(string $email, string $prenom, string $nom, string $password): UtilisateurDTO
    {

        $existingUtilisateur = $this->utilisateurRepository->getUtilisateurByEmail($email);

        if($existingUtilisateur){
            throw new \Exception('Utilisateur déjà existant.');
        }

        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        $uuid = Uuid::uuid4()->toString();

        $utilisateur = new Utilisateur($uuid, $email, $prenom, $nom, $passwordHash, 1);

        $this->utilisateurRepository->save($utilisateur);

        return $utilisateur->toDTO();
    }

    public function connexion(string $email, string $password): string
    {
        $utilisateur = $this->utilisateurRepository->getUtilisateurByEmail($email);

        if (!$utilisateur) {
            throw new \Exception('Utilisateur non trouve.');
        }

        if (!password_verify($password, $utilisateur->password)) {
            throw new \Exception('Mot de passe incorrect.');
        }

        $now = time();
        $payload = [
            'iat' => $now,
            'exp' => $now + 3600,
            'sub' => $utilisateur->id,
            'email' => $utilisateur->email,
        ];

        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

        return $jwt;
    }

}
