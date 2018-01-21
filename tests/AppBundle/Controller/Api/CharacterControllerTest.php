<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\MobTrait;

class CharacterControllerTest extends AbstractWebTestCase
{
    use MobTrait;

    public function testPostCharacterSuccess()
    {
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

        $this->assertEquals(201, $statusCode);
        $this->assertNotEmpty($response->headers->get('location'));
        $this->assertEmpty($result);
    }

}