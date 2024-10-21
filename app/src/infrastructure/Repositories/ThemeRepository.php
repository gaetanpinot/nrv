<?php

namespace nrv\infrastructure\Repositories;

use nrv\core\domain\entities\Artiste\Artiste;
use nrv\core\repositoryInterfaces\ThemeRepositoryInterface;
use \nrv\core\domain\entities\Theme\Theme;

class ThemeRepository implements ThemeRepositoryInterface
{

    public function getTheme(): array
    {
        return $this->pdo->query('SELECT * FROM artiste')->fetchAll();
    }

    public function getThemeById(string $id): Theme
    {
        $result = $this->pdo->query('SELECT * FROM theme WHERE id = ' . $id)->fetch();
        return new Artiste($result['id'], $result['label']);

    }

    public function save(Theme $theme): void
    {
        $request = $this->pdo->prepare('INSERT INTO theme (id, label) VALUES (:id, :label) ON CONFLICT (id) DO UPDATE SET label = :label');
        $request->execute([
            'id' => $theme->id,
            'label' => $theme->label,
        ]);
    }

    public function updateTheme(Theme $theme): void
    {
        $request = $this->pdo->prepare('UPDATE theme SET label = :label WHERE id = :id');
        $request->execute([
            'id' => $theme->id,
            'label' => $theme->label,
        ]);
    }

    public function deleteTheme(string $id): void
    {
        $request = $this->pdo->prepare('DELETE FROM theme WHERE id = :id');
        $request->execute(['id' => $id]);
    }
}