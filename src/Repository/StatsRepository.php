<?php

namespace App\Repository;

use App\Dictionary\Stats;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class StatsRepository
 *
 * @package App\Repository
 */
class StatsRepository
{
    /**
     * @return string|null
     */
    public function getAll(): ?string
    {
        $stats = null;

        try {
            $stats = file_get_contents(Stats::JSON_FILE_PATH);
        } catch (FileNotFoundException $fileNotFoundException){
            echo $fileNotFoundException->getMessage();
        }

        return $stats;
    }
}
