<?php

namespace App\Controller;

use App\Entity\Invitation;
use App\Repository\UserRepository;
use App\Request\UpdateInvitationRequest;
use App\Service\InvitationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use App\Repository\InvitationRepository;
use App\Request\SendInvitationRequest;



class InvitationController extends AbstractController
{
    private $invitationRepository;
    private $userRepository;

    public function __construct(InvitationRepository $invitationRepository, UserRepository $userRepository)
    {
        $this->invitationRepository = $invitationRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Send Invitation
     *
     * @Route("/api/send_invitation", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Send the Invitation",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Invitation::class, groups={"full"}))
     *     )
     * ),
     *  @OA\RequestBody(
     *          description="from - This is the sender user id </br> to - This is the reciver user id </br> message - Optional </br>",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="from",
     *                     type="integer",
     *                     description="This is the sender user id"
     *                 ),
     *                 @OA\Property(
     *                     property="to",
     *                     type="integer",
     *                     description="This is the reciever user id"
     *                 ),
     *                @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *                 example={"from": "1", "to": "1", "message": "Hello"}
     *             )
     *         )
     *     ),
     * @OA\Tag(name="Invitation")
     * @Security(name="Bearer")
     */

    public function sendInvitation(Request $request, SendInvitationRequest $sendInvitationRequest, InvitationService $invitationService): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $validation = $sendInvitationRequest->validateInvitationData($parameters);
        if (count($validation) > 0)
        {
            $errorsString = (string) $validation;
            return new Response($errorsString);
        }
        $invitation = $invitationService->getInvitationBySenderAndTo($parameters);
        if(empty($invitation))
        {
            $fromUser = $this->userRepository->find($parameters['from']);
            $toUser = $this->userRepository->find($parameters['to']);
            if(!empty($fromUser) && !empty($toUser))
            {
                $invitationDetails =  $invitationService->saveInvitation($fromUser, $toUser, $parameters);
                $response = array('invitation_id' => $invitationDetails->getId(), 'token' => $invitationDetails->getToken());
                return $this->json('Successfully sent the invitation to the user. '.json_encode($response));
            }
            else
            {
                return $this->json('User(s) not found.');
            }
        }
        else
        {
            return $this->json('Already send the invitation. ');
        }
    }

    /**
     * Update Invitation
     *
     * @Route("/api/update_invitation", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Update the Invitation",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Invitation::class, groups={"full"}))
     *     )
     * ),
     *  @OA\RequestBody(
     *          description="Invitation Status </br> 1 - Pending </br> 2 - Accepted </br> 3 - Rejected </br> 4 - Cancelled",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="status",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="invitation_id",
     *                     type="integer",
     *                     description="This id for updating the invitation"
     *                 ),
     *                @OA\Property(
     *                     property="message",
     *                     type="string"
     *                 ),
     *               @OA\Property(
     *                     property="token",
     *                     type="string"
     *                 ),
     *                 example={"status": "1", "invitation_id": "1", "token": "Hello"}
     *             )
     *         )
     *     ),
     * @OA\Tag(name="Invitation")
     * @Security(name="Bearer")
     */

    public function updateInvitation(Request $request,  UpdateInvitationRequest $updateInvitationRequest, InvitationService $invitationService): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $validation = $updateInvitationRequest->validateInvitationData($parameters);
        if (count($validation) > 0)
        {
            $errorsString = (string) $validation;
            return new Response($errorsString);
        }
        $invitationDetails =  $invitationService->getInvitation($parameters);
        if(!empty($invitationDetails))
        {
            $invitationId = $parameters['invitation_id'];
            $invitationService->updateInvitation($invitationId, $parameters);
            return $this->json('Successfully updated the Invitation details.');
        }
        else
        {
            return $this->json('No Invitation details found.');
        }
    }
}