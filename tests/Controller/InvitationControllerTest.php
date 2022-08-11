<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitationControllerTest extends WebTestCase
{
    public function testSendInvitation(): void
    {
        $baseUrl = getenv('TEST_BASE_URL');
        $client = static::createClient();
        $data = array(
            'from' => '1',
            'to' => '2',
            'message' => 'Hello..'
        );
        $client->request('POST',
            $baseUrl . '/api/send_invitation',
            [], [], [], json_encode($data));
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertNotEmpty($data);
        $this->assertResponseIsSuccessful();
    }

    public function testUpdateInvitationWithNoRecord(): void
    {
        $baseUrl = getenv('TEST_BASE_URL');
        $client = static::createClient();
        $data = array(
            'status' => 'test11@test.com',
            'invitation_id' => 'Test name',
            'token' => '1'
        );
        $client->request('POST',
            $baseUrl . '/api/update_invitation',
            [], [], [], json_encode($data));
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertEquals('No Invitation details found.', $data);
    }

    public function testUpdateInvitationRecord(): void
    {
        $baseUrl = getenv('TEST_BASE_URL');
        $client = static::createClient();
        $data = array(
            'status' => '2',
            'invitation_id' => '2e',
            'token' => 'sVrONeND7a1mxVPvI0ncsXKiM2VnxrE9bb41SapOcP6N5P30HEI17sxbREJi'
        );
        $client->request('POST',
            $baseUrl . '/api/update_invitation',
            [], [], [], json_encode($data));
        $data = json_decode($client->getResponse()->getContent(), true);
        $this->assertResponseIsSuccessful();
        $this->assertNotEmpty($data);
    }
}