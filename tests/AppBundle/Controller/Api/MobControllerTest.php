<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\MobTrait;

class MobControllerTest extends AbstractWebTestCase
{
    use MobTrait;

    public function testGetActionSuccess()
    {
        $mob = $this->newMobPersistent();

        $this->client->request(
            'GET',
            $this->generateRoute('app_mob_get', [
                'id' => $mob->getId()
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
        $this->assertEquals($result['id'], $mob->getId());
        $this->removeEntity($mob);
    }
}
