<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Service\UserManager;

/**
 * Class UserController
 *
 *
 * @Route("/api", name="api_")
 *
 * @package App\Controller
 */
class UserController
{
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
     * @return Response
     */
    public function getUsers(): Response
    {
        return new Response($this->userManager->getUsers());
    }

    /**
     * @param Request $request
     *
     * @Route("/users", methods={"POST"})
     *
     * @return Response
     */
    public function addUsers(Request $request): Response
    {
        $result = $this->userManager->addUser($request->getContent());

        return new Response($result);
    }
}
