<?php

namespace nrv\core\dto;

class UtilisateurDTO extends DTO
{
    public string $id;
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
}