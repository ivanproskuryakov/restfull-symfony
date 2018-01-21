<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\MobTrait;

class ActionControllerTest extends AbstractWebTestCase
{
    use MobTrait;

    public function testPostActionSuccess()
    {
        $mob = $this->newMobPersistent();
        $data = [
            'mob_id' => $mob->getId(),
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
