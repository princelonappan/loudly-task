<?php

namespace App\Service;

use App\Entity\Invitation;
use App\Repository\InvitationRepository;
use App\Repository\UserRepository;
use App\Service\CommonService;

class InvitationService
{
    private $invitationRepository;
    private $commonService;

    public function __construct(InvitationRepository $invitationRepository,  CommonService $commonService)
    {
        $this->invitationRepository = $invitationRepository;
        $this->commonService = $commonService;
    }

    public function saveInvitation($fromUser, $toUser, $parameters): Invitation
    {
        $randomString = $this->commonService->generateRandomString(60);
        $invitation = new Invitation();
        $invitation->setInvitationFrom($fromUser);
        $invitation->setInvitationTo($toUser);
        $invitation->setToken($randomString);
        $invitation->setMessage($parameters['message']);
        $invitation->setStatus(Invitation::STATUS_PENDING);
        $invitation->setCreatedDate(new \DateTime());
        $invitation->setUpdatedDate(new \DateTime());
        return $this->invitationRepository->save($invitation);
    }

    public function getInvitation($parameters): array
    {
        $condition = array('id' => $parameters['invitation_id'], 'token' => $parameters['token']);
        return $this->invitationRepository->getInvitation($condition);
    }

    public function updateInvitation($invitationId, $parameters)
    {
        $invitation = $this->invitationRepository->getInvitationById($invitationId);
        if(!empty($invitation))
        {
            $invitation->setStatus($parameters['status']);
            $invitation->setUpdatedDate(new \DateTime());
            return $this->invitationRepository->save($invitation);
        }
    }

    public function getInvitationBySenderAndTo($parameters): array
    {
        $condition = array('invitation_from' => $parameters['from'], 'invitation_to' => $parameters['to']);
        return $this->invitationRepository->getInvitation($condition);
    }
}
