<?php

declare(strict_types=1);

namespace ZenBox\Form\Validator;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validation;
use ZenBox\Form\FormValidator;

final class SymfonyFormValidator implements FormValidator
{
    function validate($value, array $constrains): array
    {
        $validator = Validation::createValidator();
        $constraintViolationList = $validator->validate($value, $constrains);
        assert($constraintViolationList instanceof ConstraintViolationList);
        return (array_map(function (ConstraintViolation $constraintViolation) {
            return $constraintViolation->getMessage();
        }, (array)$constraintViolationList->getIterator()));
    }
}
