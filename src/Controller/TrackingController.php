<?php

namespace App\Controller;

use App\Service\TrackingManager;
use App\Traits\JsonParser;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class TrackingController
 *
 * @Route("/api", name="api_")
 *
 * @package App\Controller
 */
class TrackingController extends ApiController
{
    use JsonParser;

    /**
     * @var TrackingManager
     */
    private $trackingManager;

    /**
     * TrackingController constructor.
     *
     * @param TrackingManager $trackingManager
     */
    public function __construct(TrackingManager $trackingManager)
    {
        $this->trackingManager = $trackingManager;
    }

    /**
     * @Route("/stats", methods={"GET"})
     */
    public function getStats(): JsonResponse
    {
        $result = $this->trackingManager->getStats();

        if (!$result) {
            return $this->notFound('Stats not found');
        }

        return $this->success($result);
    }

    /**
     * @Route("/stats", methods={"POST"})
     *
     * @param Request            $request
     * @param ValidatorInterface $validator
     *
     * @return JsonResponse
     *
     * @throws \Exception
     */
    public function addStats(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = $this->jsonDecode($request->getContent());
        $errorCheck = $this->trackingManager->isValidate($data, $validator);

        if (count($errorCheck) > 0){
            return $this->error($errorCheck);
        }

        $data = $this->trackingManager->prepareData($data);

        // must be saving data to json file
    }
}
