<?php

namespace Tests\AppBundle\Controller\Api;

use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\CharacterTrait;
use Tests\Traits\UserTrait;

class GameControllerTest extends AbstractWebTestCase
{
    use CharacterTrait;
    use UserTrait;

    public function testStatusAction()
    {
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );
        $character = $this->newCharacterPersistent(
            $user,
            $this->faker->name
        );
        $this->logIn($user);

        $this->client->request(
            'GET',
            $this->generateRoute('app_game_status'),
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

//        $this->assertEquals(200, $statusCode);

        var_dump($result);

        $this->removeEntity($character);
        $this->removeEntity($user);
    }

    public function testNewGame()
    {
        $user = $this->newUserPersistent(
            $this->faker->email,
            $this->faker->numberBetween()
        );
        $this->logIn($user);

        $this->client->request(
            'GET',
            $this->generateRoute('app_game_new'),
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
        $this->assertEmpty($result);

        $this->removeEntity($user);
    }

}
