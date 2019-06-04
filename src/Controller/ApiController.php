<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use App\Dictionary\Api;

/**
 * Class ApiController
 *
 * @package App\Controller
 */
abstract class ApiController
{
    /**
     * @param string $data
     *
     * @return JsonResponse
     */
    protected function success(string $data): JsonResponse
    {
        return new JsonResponse([
            Api::STATUS => Api::STATUS_OK,
            Api::CODE => 200,
            Api::MESSAGE => [],
            Api::RESULT => $data
        ]);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function createSuccess(string $message): JsonResponse
    {
        return new JsonResponse([
            Api::STATUS => Api::STATUS_OK,
            Api::CODE => 201,
            Api::MESSAGE => $message,
            Api::RESULT => []
        ]);
    }

    /**
     * @param array $message
     *
     * @return JsonResponse
     */
    protected function error(array $message): JsonResponse
    {
        return new JsonResponse([
            Api::STATUS => Api::STATUS_BAD_REQUEST,
            Api::CODE => 400,
            Api::MESSAGE => $message,
            Api::RESULT => []
        ]);
    }

    /**
     * @param string $message
     *
     * @return JsonResponse
     */
    protected function notFound(string $message): JsonResponse
    {
        return new JsonResponse([
            Api::STATUS => Api::STATUS_NOT_FOUND,
            Api::CODE => 404,
            Api::MESSAGE => $message,
            Api::RESULT => []
        ]);
    }
}
