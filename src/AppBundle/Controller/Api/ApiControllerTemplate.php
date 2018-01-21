<?php

namespace AppBundle\Controller\Api;

use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;

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
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    final public function postAction(Request $request): Response
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
     * @param int $id
     * @throws NotFoundHttpException
     * @return Response
     */
    final public function getAction(int $id): Response
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
     * @return Response
     */
    final public function getCollectionAction(): Response
    {
        $collection = $this->get('doctrine.orm.entity_manager')
            ->getRepository($this->model)
            ->findAll();

        $serializedCollection = $this
            ->container
            ->get('jms_serializer')
            ->serialize(
                $collection,
                'json',
                SerializationContext::create()->enableMaxDepthChecks()
            );

        return new Response($serializedCollection);
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
     * @throws ORMException
     * @throws OptimisticLockException
     */
    private function persistEntity(Request $request)
    {
        $entity = $this->get('jms_serializer')->deserialize(
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
