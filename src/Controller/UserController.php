<?php

namespace App\Controller;

use Symfony\Component\Validator\Validator\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use App\Service\UserManager;
use App\Dictionary\Api;
use App\Traits\JsonParser;

/**
 * Class UserController
 *
 *
 * @Route("/api", name="api_")
 *
 * @package App\Controller
 */
class UserController extends ApiController
{
    use JsonParser;

    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * UserController constructor.
     *
     * @param UserManager    $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/users", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $result = $this->userManager->getUsers();

        if (!$result) {
            return $this->notFound('Users not found');
        }

        return $this->success($result);
    }

    /**
     * @param Request $request
     *
     * @param ValidatorInterface $validator
     *
     * @Route("/users", methods={"POST"})
     *
     * @return JsonResponse
     */
    public function addUsers(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = $this->jsonDecode($request);
        $validateResult = $this->userManager->registrationIsValidate($data, $validator);

        if (!array_key_exists(Api::STATUS, $validateResult)) {
            return $this->error($validateResult);
        }

        $result = $this->userManager->addUser($data);

        if (!$result){
            return $this->error([Api::MESSAGE => 'User does not added, try again later']);
        }

        return $this->createSuccess('User has been added');
    }
}
