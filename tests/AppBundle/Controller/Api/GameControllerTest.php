<?php

namespace Tests\AppBundle\Controller\Api;

use AppBundle\Entity\Action;
use Tests\AppBundle\AbstractWebTestCase;
use Tests\Traits\CharacterTrait;
use Tests\Traits\MobTrait;
use Tests\Traits\UserTrait;

class GameControllerTest extends AbstractWebTestCase
{
    use CharacterTrait;
    use MobTrait;
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
            'POST',
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

        $this->assertEquals(200, $statusCode);
        $this->assertEquals(0, $result['experience']);
        $this->assertEquals(0, $result['animals_killed']);
        $this->assertEquals(0, $result['peasants_killed']);
        $this->assertEquals(0, $result['monsters_killed']);
        $this->assertEquals(true, $result['is_finished']);

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
            'POST',
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

    public function testAttackAction()
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
        $mob = $this->newMobPersistent();

        $this->client->request(
            'POST',
            $this->generateRoute('app_game_action_attack', [
                'mob' => $mob->getId(),
                'type' => Action::ACTION_TYPE_ATTACK,
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
        $this->assertEmpty($result);
    }
}
