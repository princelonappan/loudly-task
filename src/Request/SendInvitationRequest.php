<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Optional;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Collection;


class SendInvitationRequest
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateInvitationData(array $postData)
    {
        $constraints = new Collection([
            'from' => [
                new NotBlank()
            ],
            'to' => [
                new NotBlank()
            ],
            'message' => [
                new Optional()
            ]
        ]);

        return $this->validator->validate($postData, $constraints);
    }
}