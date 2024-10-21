<?php

namespace nrv\core\dto;

use Monolog\Handler\Curl\Util;
use nrv\core\domain\entities\Utilisateur\Utilisateur;

class UtilisateurDTO extends DTO
{
    public string $email;
    public string $prenom;
    public string $nom;

    public function __construct(Utilisateur $utilisateur)
    {
        $this->email = $utilisateur->getEmail();
        $this->prenom = $utilisateur->getPrenom();
        $this->nom = $utilisateur->getNom();
    }
}