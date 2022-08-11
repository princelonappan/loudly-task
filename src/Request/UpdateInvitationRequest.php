<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Collection;


class UpdateInvitationRequest
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateInvitationData(array $postData)
    {
        $constraints = new Collection([
            'status' => [
                new NotBlank()
            ],
            'invitation_id' => [
                new NotBlank()
            ],
            'token' => [
                new NotBlank()
            ]
        ]);

        return $this->validator->validate($postData, $constraints);
    }
}