<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 *
 * @package App\Controller
 */
class DefaultController
{
    /**
     * @Route("/")
     *
     * @return Response
     *
     * @throws \Exception
     */
    public function index(): Response
    {
        return new Response(
            '<html><body>Start page is alive</body></html>'
        );
    }
}
