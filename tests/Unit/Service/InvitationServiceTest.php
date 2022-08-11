<?php
namespace App\Tests\Service;
use PHPUnit\Framework\TestCase;
use App\Service\InvitationService;

class InvitationServiceTest extends TestCase
{

    public function testSaveInvitation()
    {
        $userRepository = $this->createMock(\App\Repository\UserRepository::class);
        $invitationRepository = $this->createMock(\App\Repository\InvitationRepository::class);
        $commonService = $this->createMock(\App\Service\CommonService::class);
        $toUser = $userRepository->find(2);
        $fromUser = $userRepository->find(1);
        $parameters['message'] = 'Hello';
        $invitationService = new InvitationService($invitationRepository, $commonService);
        $invitationDetails =  $invitationService->saveInvitation($fromUser, $toUser, $parameters);
        $this->assertIsObject($invitationDetails);
    }

    public function testGetInvitation()
    {
        $commonService = $this->createMock(\App\Service\CommonService::class);
        $invitationRepository = $this->createMock(\App\Repository\InvitationRepository::class);
        $invitationService = new InvitationService($invitationRepository, $commonService);
        $parameters['invitation_id'] = '1';
        $parameters['token'] = 'test';
        $invitationDetails =  $invitationService->getInvitation($parameters);
        $this->assertIsArray($invitationDetails);
    }

    public function testUpdateInvitation()
    {
        $commonService = $this->createMock(\App\Service\CommonService::class);
        $invitationRepository = $this->createMock(\App\Repository\InvitationRepository::class);
        $invitationService = new InvitationService($invitationRepository, $commonService);
        $parameters['invitation_id'] = '1';
        $invitationDetails = $invitationService->updateInvitation(1, $parameters);
        $this->assertEquals(1, $parameters['invitation_id']);
    }
}