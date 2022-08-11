<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Collection;


class UserRequest
{
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validateUserData(array $postData)
    {
        $constraints = new Collection([
            'name' => [
                new NotBlank()
            ],
            'email' => [
                new NotBlank()
            ]
        ]);

        return $this->validator->validate($postData, $constraints);
    }
}