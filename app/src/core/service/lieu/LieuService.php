<?php
namespace nrv\core\service\lieu;

use nrv\core\dto\LieuDTO;
use nrv\infrastructure\Repositories\LieuRepository;

class LieuService implements LieuServiceInterface{

    protected LieuRepository $lieuRepository;

    public function __construct(LieuRepository $lieuRepository){
        $this->lieuRepository = $lieuRepository;
    }

    public function getLieux(): array{
        $lieux = $this->lieuRepository->getLieux();
        $res = array();
        foreach ($lieux as $lieu) {
            $res[] = $lieu->toDTO();
        }
        return $res;
    }

    public function getLieuById(string $id_lieu): LieuDTO{
        $lieu = $this->lieuRepository->getLieuById($id_lieu);
        if (!$lieu) {
            throw new \Exception("Lieu non trouvé : $id_lieu");
        }
        return $lieu->toDTO();
    }
}