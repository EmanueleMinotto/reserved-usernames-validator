<?php

namespace EmanueleMinotto\ReservedUsernamesValidator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * Validator for reserved usernames.
 */
class NotReservedValidator extends ConstraintValidator
{
    /**
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty(trim($value))) {
            return;
        }

        $values = json_decode(
            file_get_contents(__DIR__.'/../data/reserved-usernames.json'),
            true
        );

        if (in_array($value, $values)) {
            $this->context->addViolation($constraint->message, [
                '%value%' => $value,
            ]);
        }
    }
}
