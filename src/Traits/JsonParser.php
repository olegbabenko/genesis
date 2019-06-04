<?php

namespace App\Traits;

/**
 * Trait JsonParser
 *
 * @package App\Traits
 */
trait JsonParser
{
    /**
     * @param string $data
     *
     * @return array|null
     */
    public function jsonDecode(string $data): ?array
    {
        return json_decode($data, true);
    }

    /**
     * @param array $data
     *
     * @return string|null
     */
    public function jsonEncode(array $data): ?string
    {
        return json_encode($data);
    }
}
