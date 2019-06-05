<?php

namespace tests;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

/**
 * Class LoginControllerTest
 *
 * @package tests
 */
class LoginControllerTest extends TestCase
{
    /**
     * @return
     */
    public function testUserLogin()
    {
        $client = new  Client(array(
            'base_uri' => 'http://localhost',
            'request.options' => array(
                'exceptions' => false,
                )
        ));

        $data = array(
            'nickname' => 'john_doe',
            'password' => 'qwertyqwerty'
        );

        $request = $client->post('/api/login',  $data);

        $this->assertEquals(200, $request->getStatusCode());

    }
}
