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
    protected int $role;

    public function __construct(string $id, string $email, string $prenom, string $nom, string $password, int $role)
    {
        $this->id = $id;
        $this->email = $email;
        $this->prenom = $prenom;
        $this->nom = $nom;
        $this->password = $password;
        $this->role= $role;
    }

    public function toDTO(): UtilisateurDTO{
        return new UtilisateurDTO($this);

    }
}
