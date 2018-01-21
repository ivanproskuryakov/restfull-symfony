<?php

namespace AppBundle\Controller\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

use AppBundle\Entity\User;

class UserController extends ApiControllerTemplate
{
    /**
     * @var string
     */
    protected $model = User::class;

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAction(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        $this->get('app_user.service')->login(
            $payload['email'],
            $payload['password']
        );

        return new JsonResponse();
    }


    /**
     * @return mixed
     */
    protected function postPreProcessor()
    {
        $request = $this->get('request_stack')->getCurrentRequest();

        if (!$request->headers->get('x-user-agreement')) {
            throw new BadRequestHttpException('Terms of use must be accepted.');
        }
    }
}
