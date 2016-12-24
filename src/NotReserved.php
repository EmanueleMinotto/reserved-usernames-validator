<?php

namespace EmanueleMinotto\ReservedUsernamesValidator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NotReserved extends Constraint
{
    /**
     * Validation message for reserved usernames.
     *
     * @var string
     */
    public $message = 'The value "%value%" is reserved.';
}
