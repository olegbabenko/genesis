<?php

namespace App\Traits;

/**
 * Trait DataCollector
 *
 * @package App\Traits
 */
trait DataCollector
{
    /**
     * @param array $newData
     * @param array $existData
     *
     * @return array
     */
    public function mergeData(array $existData, array $newData): array
    {
        $newArray = [];

        foreach ($existData as $datum){
            $newArray[] = $datum;
        }

        $newArray[] = $newData;

        return $newArray;
    }
}
