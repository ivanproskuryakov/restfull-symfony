<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\UserTrait;

class UserControllerTest extends AbstractWebTestCase
{
    use UserTrait;

    public function testLoginUserActionSuccess()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->numberBetween(),
        ];
        $user = $this->newUserPersistent(
            $data['email'],
            $data['password']
        );

        $this->client->request(
            'POST',
            $this->generateRoute('app_user_login'),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json'
            ],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $statusCode = $response->getStatusCode();
        $this->assertEquals(200, $statusCode);

        $this->removeEntity($user);
    }

    public function testLoginUserActionFailWrongCredentials()
    {
        $data = [
            'email' => $this->faker->email,
            'password' => $this->faker->numberBetween(),
        ];
        $wrongData = [
            'email' => $this->faker->email,
            'password' => 'wrong!',
        ];

        $user = $this->newUserPersistent(
            $data['email'],
            $data['password']
        );

        $this->client->request(
            'POST',
            $this->generateRoute('app_user_login'),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($wrongData)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals(422, $statusCode);
        $this->assertEquals('A user with such Email doesn\'t exists', $result['message']);
        $this->removeEntity($user);
    }

    public function testPostUserActionFailUserAgreement()
    {
        $data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'plainPassword' => 'password',
        ];

        $this->client->request(
            'POST',
            $this->generateRoute('app_user_post'),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals(400, $statusCode);
        $this->assertEquals('Terms of use must be accepted.', $result['message']);
    }

    public function testPostUserActionFailDuplicatedEmail()
    {
        $data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'plainPassword' => 'password',
        ];

        $user = $this->newUserPersistent(
            $data['email'],
            $data['plainPassword']
        );

        $this->client->request(
            'POST',
            $this->generateRoute('app_user_post'),
            [],
            [],
            [
                'HTTP_X-USER-AGREEMENT' => 1,
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals(400, $statusCode);
        $this->assertEquals(1, count($result['errors']));
        $this->assertEquals('This email is already in use', $result['errors']['email']);
        $this->removeEntity($user);
    }

    public function testPostUserActionSuccess()
    {
        $data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'plainPassword' => 'password',
        ];

        $this->client->request(
            'POST',
            $this->generateRoute('app_user_post'),
            [],
            [],
            [
                'HTTP_X-USER-AGREEMENT' => 1,
                'CONTENT_TYPE' => 'application/json',
            ],
            json_encode($data)
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertNotEmpty($response->headers->get('location'));
        $this->assertEquals(201, $statusCode);
        $this->assertEmpty($result);
    }

    public function testGetActionSuccess()
    {
        $data = [
            'email' => $this->faker->email,
            'name' => $this->faker->name,
            'username' => $this->faker->userName,
            'plainPassword' => 'password',
        ];

        $user = $this->newUserPersistent(
            $data['email'],
            $data['plainPassword']
        );

        $this->client->request(
            'GET',
            $this->generateRoute('app_user_get', [
                'id' => $user->getId()
            ]),
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ]
        );

        $response = $this->client->getResponse();
        $content = $response->getContent();
        $statusCode = $response->getStatusCode();
        $result = json_decode($content, true);

        $this->assertEquals($user->getEmail(), $result['email']);
        $this->assertArrayHasKey('id', $result);
        $this->assertArrayNotHasKey('password', $result);
        $this->assertArrayNotHasKey('salt', $result);
        $this->assertEquals(200, $statusCode);
        $this->removeEntity($user);
    }
}
