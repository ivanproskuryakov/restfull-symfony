<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

use Doctrine\ORM\EntityManager;
use Faker;

abstract class AbstractTestCase extends KernelTestCase
{
    /**
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var KernelInterface
     */
    protected static $kernel = null;

    /**
     * @var integer
     */
    protected static $seed = 2000;

    /**
     * @param $entity
     */
    public function removeEntity($entity)
    {
        $this->em->remove($entity);
        $this->em->flush();

        $isFound = $this
            ->em
            ->getRepository(get_class($entity))
            ->findOneBy(['id' => $entity->getId()]);

        $this->assertNull($isFound);
    }

    protected function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->faker = Faker\Factory::create();

        parent::setUp();
    }

    protected function tearDown()
    {
        unset($this->em);

        $refl = new \ReflectionObject($this);
        foreach ($refl->getProperties() as $prop) {
            if ((!($prop->isStatic())) and (0 !== strpos($prop->getDeclaringClass()->getName(), 'PHPUnit_'))) {
                $prop->setAccessible(true);
                $prop->setValue($this, null);
            }
        }

        parent::tearDown();
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    public function getContainer()
    {
        return static::$kernel->getContainer();
    }

    /**
     * @return int
     */
    public static function getNextSeed()
    {
        self::$seed += 1;

        return self::$seed;
    }

    protected function getFaker()
    {
        return $this->faker;
    }
}
