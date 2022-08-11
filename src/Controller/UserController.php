<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use OpenApi\Annotations as OA;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\Annotation\Security;
use App\Entity\User;
use App\Repository\UserRepository;
use App\Request\UserRequest;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * List user.
     *
     * @Route("/api/users", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns all the users",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class, groups={"full"}))
     *     )
     * )
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     */

    public function index(): Response
    {
        $users = $this->userRepository->findAllUser();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            ];
        }
        return $this->json($data);
    }


    /**
     * List user.
     *
     * @Route("/api/users", methods={"POST"})
     * @OA\Response(
     *     response=200,
     *     description="Returns all the users",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=User::class, groups={"full"}))
     *     )
     * ),
     * @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 example={"email": "test@test.com", "name": "Jessica Smith"}
     *             )
     *         )
     *     ),
     * @OA\Tag(name="User")
     * @Security(name="Bearer")
     */

    public function new(Request $request, UserRequest $userRequest): Response
    {
        $parameters = json_decode($request->getContent(), true);
        $validation = $userRequest->validateUserData($parameters);
        if (count($validation) > 0)
        {
            $errorsString = (string)$validation;
            return new Response($errorsString);
        }
        $user = new User();
        $user->setName($parameters['name']);
        $user->setEmail($parameters['email']);
        $userDetails = $this->userRepository->save($user);
        return $this->json('Created new user successfully');
    }


}