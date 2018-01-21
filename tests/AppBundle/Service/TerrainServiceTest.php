<?php

namespace AppBundle\Service;

use Tests\AppBundle\AbstractTestCase;

class TerrainServiceTest extends AbstractTestCase
{

    public function testGenerateTerrainSuccess()
    {
        $this->em->createQuery('DELETE AppBundle:Terrain t')->execute();
        $this->getContainer()->get('app_terrain.service')->generateTerrain();

        $terrain = $this->em->getRepository('AppBundle:Terrain')->findBy([
           'x'=> 1,
           'y'=> 1,
        ]);

        $this->assertNotEmpty($terrain);

    }
}
