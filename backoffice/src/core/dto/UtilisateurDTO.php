<?php

namespace nrv\back\core\dto;

use nrv\back\core\domain\entities\Utilisateur\Utilisateur;

class UtilisateurDTO extends DTO
{
    protected string $id;
    protected string $email;
    protected string $prenom;
    protected string $nom;

    public function __construct(Utilisateur $utilisateur)
    {
        $this->id = $utilisateur->id;
        $this->email = $utilisateur->email;
        $this->prenom = $utilisateur->prenom;
        $this->nom = $utilisateur->nom;
    }
}
