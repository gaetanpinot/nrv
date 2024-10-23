<?php

namespace nrv\core\dto;

use nrv\core\domain\entities\Utilisateur\Utilisateur;

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
