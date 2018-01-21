<?php

namespace Tests\AppBundle\Controller\Api;

use AppBundle\Entity\Action;
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
            'type' => Action::ACTION_TYPE_ATTACK,
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
        $parts = explode('/', $response->headers->get('location'));
        $id = array_pop($parts);

        $this->assertEquals(201, $statusCode);
        $this->assertNotEmpty($response->headers->get('location'));
        $this->assertEmpty($result);

        $action = $this->em->getRepository('AppBundle:Action')->find($id);

        $this->removeEntity($action);
        $this->removeEntity($mob);
        $this->removeEntity($user);
    }
}
