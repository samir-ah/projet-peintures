<?php

namespace App\Tests;

use Symfony\Component\Panther\PantherTestCase;

class HomeFunctionalTest extends PantherTestCase
{
    public function testShouldDisplayHomepage(): void
    {
        $client = static::createPantherClient();
        $crawler = $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('nav', 'Accueil');
    }
}
