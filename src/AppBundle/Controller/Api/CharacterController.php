<?php

namespace AppBundle\Controller\Api;

use AppBundle\Entity\Character;

class CharacterController extends ApiControllerTemplate
{
    /**
     * @var string
     */
    protected $model = Character::class;

}