<?php

namespace App\Service;

use App\DTO\ValidationError;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService
{
    private ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator  = $validator;
    }

    /**
     * @param object $data
     * @return ValidationError[] | null
     */
    public function validate($data): array
    {
        $violations = $this->validator->validate($data);

        $errorMessages = [];

        foreach ($violations as $violation) {
            /** @var ConstraintViolationInterface $violation */
            $errorMessages[] = new ValidationError(
                $violation->getPropertyPath(),
                $violation->getMessage(),
            );
        }

        return $errorMessages;
    }
}
