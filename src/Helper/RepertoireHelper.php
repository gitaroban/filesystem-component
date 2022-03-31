<?php
declare(strict_types=1);

namespace Gitaroban\FilesystemComponent;

use Symfony\Component\Filesystem\Filesystem;

class RepertoireHelper
{
    /**
     * @param array|string $repertoires
     *
     * @return string
     */
    public static function genererChemin(array|string $repertoires): string
    {
        return implode(DIRECTORY_SEPARATOR, $repertoires);
    }

    /**
     * @param iterable|string $repertoires
     * @param int             $mode
     *
     * @return void
     */
    public static function creer(iterable|string $repertoires, int $mode = 0777): void
    {
        if (empty($repertoires)) {
            return;
        }

        $filesystem = new Filesystem();

        if (is_iterable($repertoires)) {
            foreach ($repertoires as $repertoire) {
                if ($filesystem->exists($repertoire)) {
                    continue;
                }
                self::creerRecursivement($repertoire, $mode);
            }
            return;
        }

        if (is_string($repertoires)) {
            if ($filesystem->exists($repertoires)) {
                return;
            }
            self::creerRecursivement($repertoires, $mode);
        }
    }

    /**
     * @param string $repertoires
     * @param int    $mode
     *
     * @return void
     */
    private static function creerRecursivement(string $repertoires, int $mode = 0777): void
    {
        if (0 === strlen($repertoires)) {
            return;
        }

        $sousDossiers = explode(DIRECTORY_SEPARATOR, $repertoires);
        if (str_starts_with($repertoires, DIRECTORY_SEPARATOR)) {
            unset($sousDossiers[0]);
        }

        $repertoiresACreer = [];
        $nombreDeParties = count($sousDossiers);
        for ($i = 0; $i <= $nombreDeParties; $i++) {
            $chemin = self::genererChemin(array_slice($sousDossiers, 0, $i));
            if (!empty($chemin)) {
                $repertoiresACreer[] = DIRECTORY_SEPARATOR . $chemin;
            }
        }

        (new Filesystem())
            ->mkdir($repertoiresACreer, $mode);
    }
}
