<?php

namespace nrv\infrastructure\Repositories;

use DI\Container;
use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\repositoryInterfaces\ThemeRepositoryInterface;
use \nrv\core\domain\entities\Theme\Theme;
use PDO;

class ThemeRepository implements ThemeRepositoryInterface
{
    protected PDO $pdo;

    public function __construct(Container $cont){
        $this->pdo = $cont->get('pdo.commun');
    }
    public function getThemes(): array
    {
        return $this->pdo->query('SELECT * FROM theme')->fetchAll();
    }

    public function getThemeById(int $id): Theme
    {
        $result = $this->pdo->prepare('SELECT * FROM theme WHERE id = :id');
        $result->execute(['id' => $id]);
        $result = $result->fetch();
        return new Theme($result['id'], $result['label']);
    }

    public function getThemeByLabel(string $label): Theme
    {
        $result = $this->pdo->prepare('SELECT * FROM theme WHERE label = :label');
        $result->execute(['label' => $label]);
        $result = $result->fetch();
        return new Theme($result['id'], $result['label']);
    }

    public function save(Theme $theme): void
    {
        $request = $this->pdo->prepare('INSERT INTO theme (id, label) VALUES (:id, :label) ON CONFLICT (id) DO UPDATE SET label = :label');
        $request->execute([
            'id' => $theme->id,
            'label' => $theme->label,
        ]);
        $request = $request->fetch();
    }

    public function updateTheme(Theme $theme): void
    {
        $request = $this->pdo->prepare('UPDATE theme SET label = :label WHERE id = :id');
        $request->execute([
            'id' => $theme->id,
            'label' => $theme->label,
        ]);
        $request = $request->fetch();
    }

    public function deleteTheme(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM theme WHERE id = :id');
        $request->execute(['id' => $id]);
        $request = $request->fetch();
    }
}