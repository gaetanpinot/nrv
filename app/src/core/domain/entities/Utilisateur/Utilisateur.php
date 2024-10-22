<?php

namespace nrv\core\domain\entities\Utilisateur;

use nrv\core\domain\entities\Entity;
use nrv\core\dto\UtilisateurDTO;

class Utilisateur extends Entity
{
    protected string $id;
    protected string $email;
    protected string $prenom;
    protected string $nom;
    protected string $password;

    public function __construct(string $id, string $email, string $prenom, string $nom, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->password = $password;
    }

    public function toDTO(): UtilisateurDTO
    {
        return new UtilisateurDTO($this);

    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }
}
