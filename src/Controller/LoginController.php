<?php

namespace App\Controller;

use App\Dictionary\Api;
use App\Dictionary\Users;
use App\Service\UserManager;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class LoginController
 *
 * @Route("/api", name="api_")
 *
 * @package App\Controller
 */
class LoginController extends ApiController
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * LoginController constructor.
     *
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * @Route("/login", methods={"POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function userLogin(Request $request): JsonResponse
    {
        $userData = json_decode($request->getContent(), true);

        if (!array_key_exists(Users::NICK_NAME, $userData)){
            return $this->error($this->getMessage(Users::NICK_NAME));
        }

        if (!array_key_exists(Users::PASSWORD, $userData)){
            return $this->error($this->getMessage(Users::PASSWORD));
        }

        $result = $this->userManager->login($userData[Users::NICK_NAME], $userData[Users::PASSWORD]);

        if (!$result){
            return $this->notFound('Nickname or password is not correct');
        }

        return $this->success('Authorization was successful');
    }

    /**
     * @param string $parameter
     *
     * @return array
     */
    private function getMessage(string $parameter): array
    {
        return [
            Api::MESSAGE => sprintf('%s is required value', $parameter)
        ];
    }
}