<?php

namespace AppBundle\Validation;

use AppBundle\Service\UserService;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class UniqueUserEmailValidator extends ConstraintValidator
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @param string $value
     * @param Constraint $constraint
     */
    public function validate($value, Constraint $constraint)
    {
        if (null === $value) {
            return;
        }
        $user = $this->userService->findUserBy([
            'email' => $value,
            'deletedAt' => null,
        ]);

        if ($user) {
            $this->context
                ->buildViolation($constraint->message)
                ->setParameter('%email%', $value)
                ->addViolation()
            ;
        }
    }
}
