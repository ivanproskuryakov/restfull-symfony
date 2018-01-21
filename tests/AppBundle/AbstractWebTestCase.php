<?php

namespace Tests\AppBundle;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use AppBundle\Entity\User;

abstract class AbstractWebTestCase extends AbstractTestCase
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var string
     */
    protected static $httpHost = null;

    /**
     * @param string $httpHost
     */
    public static function setUpBeforeClass($httpHost = '127.0.0.1')
    {
        static::$httpHost = $httpHost;
    }

    /**
     * @param $name
     * @param array $parameters
     * @return string
     */
    public function generateRoute($name, $parameters = [])
    {
        $route = $this
            ->getContainer()
            ->get('router')
            ->generate($name, $parameters);

        return $route;
    }

    protected function setUp()
    {
        parent::setUp();

        $this->client = static::createClient([], ['HTTP_HOST' => static::$httpHost]);
    }

    protected function tearDown()
    {
        unset($this->client);

        parent::tearDown();
    }

    /**
     * @param array $options
     * @param array $server
     * @return Client
     */
    protected static function createClient(array $options = array(), array $server = array())
    {
        $client = static::$kernel->getContainer()->get('test.client');
        $client->setServerParameters($server);

        return $client;
    }

    /**
     * @param User $user
     */
    protected function logIn(User $user)
    {
        $session = $this->client->getContainer()->get('session');
        $firewallContext = 'main';

        $token = new UsernamePasswordToken(
            $user,
            null,
            $firewallContext,
            ['ROLE_USER']
        );
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
