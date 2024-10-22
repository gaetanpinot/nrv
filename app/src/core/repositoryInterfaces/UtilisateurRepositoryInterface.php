<?php
namespace nrv\core\repositoryInterfaces;

use nrv\core\domain\entities\Utilisateur\Utilisateur;

interface UtilisateurRepositoryInterface{
    public function getUtilisateurs(): array;
    public function getUtilisateurByEmail(string $email): Utilisateur;
    public function save(Utilisateur $utilisateur): void;
    public function updateUtilisateur(Utilisateur $utilisateur): void;
    public function deleteUtilisateur(string $id): void;
}