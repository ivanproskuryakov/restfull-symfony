<?php

namespace AppBundle\Controller\Api;

use JMS\Serializer\SerializationContext;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use AppBundle\Exception\ValidationFailedException;

abstract class ApiControllerTemplate extends Controller
{
    /**
     * @var string
     */
    protected $model;

    /**
     * @param Request $request
     * @return mixed
     */
    final public function postAction(Request $request)
    {
        $this->postPreProcessor();
        $entity = $this->persistEntity($request);

        // Pass response
        $route = str_replace(
            "_post",
            '_get',
            $this->get('request_stack')->getCurrentRequest()->get('_route')
        );
        $url = $this->generateUrl(
            $route,
            ['id' => $entity->getId()],
            true // absolute
        );

        $response = new Response();
        $response->setStatusCode(201);
        $response->headers->set('Location', $url);

        return $response;
    }

    /**
     * @param integer $id
     * @throws NotFoundHttpException
     * @return mixed
     */
    final public function getAction($id)
    {
        $entity = $this->get('doctrine.orm.entity_manager')
            ->getRepository($this->model)
            ->find($id);

        if (null === $entity) {
            throw new NotFoundHttpException();
        }

        $serializedEntity = $this
            ->container
            ->get('jms_serializer')
            ->serialize(
                $entity,
                'json',
                SerializationContext::create()->enableMaxDepthChecks()
            );

        return new Response($serializedEntity);
    }

    /**
     * @return mixed
     */
    protected function postPreProcessor()
    {
        // Empty by default
    }

    /**
     * @param Request $request
     * @return mixed
     */
    private function persistEntity(Request $request)
    {
        $entity = $this->get('serializer')->deserialize(
            $request->getContent(),
            $this->model,
            'json'
        );
        // Force constructor to be called
        // Alt see: https://stackoverflow.com/questions/31948118/jms-serializer-why-are-new-objects-not-being-instantiated-through-constructor
        $entity->__construct();

        $violations = $this->get('validator')->validate($entity);

        if ($violations->count()) {
            throw new ValidationFailedException($violations);
        }

        $em = $this->get('doctrine.orm.entity_manager');
        $em->persist($entity);
        $em->flush();

        return $entity;
    }
}
