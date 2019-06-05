<?php

namespace App\Traits;

use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Trait ErrorParser
 *
 * @package App\Traits
 */
trait ErrorParser
{
    /**
     * @param $violations
     *
     * @return array|null
     */
    public function checkErrors($violations): array
    {
        $errorMessages = [];

        if (count($violations) > 0) {
            $accessor = PropertyAccess::createPropertyAccessor();

            foreach ($violations as $violation) {
                $accessor->setValue($errorMessages,
                    $violation->getPropertyPath(),
                    $violation->getMessage());
            }
        }

        return $errorMessages;
    }
}
