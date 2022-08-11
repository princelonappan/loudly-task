<?php
namespace App\Tests\Entity;

use App\Entity\Invitation;
use PHPUnit\Framework\TestCase;
use Doctrine\Common\Persistence\ObjectRepository;


class InvitationTest extends TestCase
{
    public function testInvitationCreate()
    {
        $invitation = new Invitation();
        $userRepository = $this->createMock(\App\Repository\UserRepository::class);
        $toUser = $userRepository->find(2);
        $fromUser = $userRepository->find(1);
        $invitation->setInvitationFrom($fromUser);
        $invitation->setInvitationTo($toUser);
        $invitation->setStatus(Invitation::STATUS_PENDING);
        $invitation->setMessage("Hello");
        $date = new \DateTime();
        $invitation->setToken("YetsheXlwkeys");
        $invitation->setUpdatedDate($date);
        $invitation->setCreatedDate($date);
        $this->assertEquals($fromUser, $invitation->getInvitationFrom());
        $this->assertEquals($toUser, $invitation->getInvitationTo());
        $this->assertEquals(Invitation::STATUS_PENDING, $invitation->getStatus());
        $this->assertEquals("Hello", $invitation->getMessage());
        $this->assertEquals("YetsheXlwkeys", $invitation->getToken());
        $this->assertEquals($date, $invitation->getUpdatedDate());
        $this->assertEquals($date, $invitation->getCreatedDate());
    }
}