<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultTest extends WebTestCase
{
    /**
     * @dataProvider getUrlsPages
     */
    public function testerToutesLesPages($url): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', $url);
        $this->assertResponseIsSuccessful();
    }

    public function getUrlsPages(): \Generator {
            yield "page d'accueil" => ['/'];
            yield "page about us" => ['/about-us'];
            yield "page des wishes" => ['/wish/'];
            yield "page de un seul wish" => ['/wish/detail/1'];
    }
}
