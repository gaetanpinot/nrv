<?php

namespace nrv\core\domain\entities\Utilisateur;

use nrv\core\domain\entities\Entity;
use nrv\core\dto\UtilisateurDTO;

class Utilisateur extends Entity
{
    public ?string $id;
    public string $email;
    public string $prenom;
    public string $nom;

    public function __construct($id, $email, $prenom, $nom)
    {
        $this->id = $id;
        $this->email = $email;
        $this->prenom = $prenom;
        $this->nom = $nom;
    }

    public function toDTO(): UtilisateurDTO
    {
        return new UtilisateurDTO($this->id, $this->email, $this->prenom, $this->nom);

    }
}