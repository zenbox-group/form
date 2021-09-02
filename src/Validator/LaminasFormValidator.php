<?php

declare(strict_types=1);

namespace ZenBox\Form\Validator;

use Laminas\Validator\ValidatorChain;
use Laminas\Validator\ValidatorInterface;
use ZenBox\Form\FormValidator;

final class LaminasFormValidator implements FormValidator
{
    function validate($value, array $constrains): array
    {
        $validatorChain = new ValidatorChain();
        foreach ($constrains as $constrain) {
            assert($constrain instanceof ValidatorInterface);
            $validatorChain->attach($constrain, true);
        }
        $validatorChain->isValid($value);
        return $validatorChain->getMessages();
    }
}
