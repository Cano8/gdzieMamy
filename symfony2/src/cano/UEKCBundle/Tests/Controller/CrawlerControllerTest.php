<?php

namespace cano\UEKCBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CrawlerControllerTest extends WebTestCase
{
    public function testMaincrawl()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/mainCrawl');
    }

}
