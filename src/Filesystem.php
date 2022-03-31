<?php
declare(strict_types=1);

namespace Gitaroban\FilesystemComponent;

use Symfony\Component\Filesystem\Filesystem as SymfonyFilesystem;

class Filesystem extends SymfonyFilesystem
{
    /**
     * @param string|iterable $fichiers
     *
     * @return bool
     */
    public function estIntrouvable(string|iterable $fichiers): bool
    {
        return !$this->exists($fichiers);
    }
}
