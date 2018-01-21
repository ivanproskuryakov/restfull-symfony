<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\MobTrait;
use Tests\Traits\TerrainTrait;

class TerrainControllerTest extends AbstractWebTestCase
{
    use MobTrait;
    use TerrainTrait;

    public function testGetActionSuccess()
    {
        $mob = $this->newMob();
        $terrain = $this->newTerrainPersistent(
            $this->faker->randomNumber(0, 9999999),
            $this->faker->randomNumber(0, 9999999),
            $mob
        );

        $this->client->request(
            'GET',
            $this->generateRoute('app_terrain_get', [
                'id' => $terrain->getId()
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
        $this->assertEquals($result['id'], $terrain->getId());
        $this->removeEntity($terrain);
    }

    public function testGetCollectionActionSuccess()
    {
        $mob = $this->newMob();
        $terrain = $this->newTerrainPersistent(
            $this->faker->randomNumber(0, 9999999),
            $this->faker->randomNumber(0, 9999999),
            $mob
        );


        $this->client->request(
            'GET',
            $this->generateRoute('app_terrain_get_collection'),
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
        $this->assertNotEmpty($result);

        $this->removeEntity($terrain);
    }
}
