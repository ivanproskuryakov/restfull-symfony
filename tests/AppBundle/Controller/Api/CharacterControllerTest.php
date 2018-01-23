<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\MobTrait;
use Tests\Traits\UserTrait;

class CharacterControllerTest extends AbstractWebTestCase
{
    use UserTrait;
    use MobTrait;

    public function testPostCharacterSuccess()
    {
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );
        $this->logIn($user);

        $data = [
            'name' => $this->faker->name,
        ];

        $this->client->request(
            'POST',
            $this->generateRoute('app_character_post'),
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
        $parts = explode('/', $response->headers->get('location'));
        $characterId = array_pop($parts);

        $this->assertEquals(201, $statusCode);
        $this->assertNotEmpty($response->headers->get('location'));
        $this->assertEmpty($result);

        // Ensure that character are included in user's API

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

        $this->assertEquals(200, $statusCode);
        $this->assertEquals($result['character']['id'], $characterId);
    }
}
