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

    public function testPostActionSuccess()
    {
//        $user = $this->newUserPersistent(
//            $this->faker->email,
//            $this->faker->numberBetween()
//        );
//        $this->logIn($user);
//        $mob = $this->newMobPersistent();
//
//        $data = [
//            'type' => Action::ACTION_TYPE_ATTACK,
//            'mob' => [
//                'id' => $mob->getId()
//            ],
//        ];
//
//        $this->client->request(
//            'POST',
//            $this->generateRoute('app_action_post'),
//            [],
//            [],
//            [
//                'CONTENT_TYPE' => 'application/json',
//            ],
//            json_encode($data)
//        );
//
//        $response = $this->client->getResponse();
//        $content = $response->getContent();
//        $statusCode = $response->getStatusCode();
//        $result = json_decode($content, true);
//        $parts = explode('/', $response->headers->get('location'));
//        $id = array_pop($parts);
//
//        $this->assertEquals(201, $statusCode);
//        $this->assertNotEmpty($response->headers->get('location'));
//        $this->assertEmpty($result);
//
//        $action = $this->em->getRepository('AppBundle:Action')->find($id);
//
//        $this->removeEntity($action);
//        $this->removeEntity($mob);
//        $this->removeEntity($user);
    }

}
