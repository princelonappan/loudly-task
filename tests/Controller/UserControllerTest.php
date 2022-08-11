<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class UserControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $baseUrl = getenv('TEST_BASE_URL');
        $client = static::createClient();
        $client->request('GET', $baseUrl . '/api/users');
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertNotEmpty($data);
    }

    public function testCreateUser(): void
    {
        $baseUrl = getenv('TEST_BASE_URL');
        $client = static::createClient();
        $data = array(
            'email' => 'test11@test.com',
            'name' => 'Test name'
        );
        $client->request('POST',
            $baseUrl . '/api/users',
            [], [], [], json_encode($data));
        $this->assertResponseIsSuccessful();
    }
}