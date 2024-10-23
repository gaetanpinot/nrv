<?php
namespace nrv\back\core\repositoryInterfaces;

use nrv\back\core\domain\entities\Utilisateur\Utilisateur;

interface UtilisateurRepositoryInterface{
    public function getUtilisateurs(): array;
    public function getUtilisateurByEmail(string $email): Utilisateur;
    public function save(Utilisateur $utilisateur): void;
    public function updateUtilisateur(Utilisateur $utilisateur): void;
    public function deleteUtilisateur(Utilisateur $utilisateur): void;
}