<?php

namespace cano\UEKCBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AutocompleteControllerTest extends WebTestCase
{
    public function testGroupsorteachers()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/groupsOrTeachers');
    }

}
