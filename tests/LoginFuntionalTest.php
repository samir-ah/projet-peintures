<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginFuntionalTest extends WebTestCase
{
    public function testShouldDisplayLoginPage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }
    public function testvisitingWhileLoggedIn()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $buttonCrawlerNode = $crawler->selectButton('Sign in');
        $form = $buttonCrawlerNode->form([
            'email' => 'user@test.com',
            'password' => 'password',
        ]);
        $client->submit($form);
        $crawler = $client->request('GET','/login');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('div','You are logged in as user@test.com');
    }
}
