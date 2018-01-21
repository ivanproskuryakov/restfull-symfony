<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\MobTrait;
use Tests\Traits\UserTrait;

class ActionControllerTest extends AbstractWebTestCase
{
    use UserTrait;
    use MobTrait;

    public function testPostActionSuccess()
    {
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );
        $this->logIn($user);
        $mob = $this->newMobPersistent();

        $data = [
            'type' => '1123',
            'mob' => [
                'id' => $mob->getId()
            ],
        ];

        $this->client->request(
            'POST',
            $this->generateRoute('app_action_post'),
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
        $this->removeEntity($mob);
    }
}
