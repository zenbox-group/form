<?php

declare(strict_types=1);

namespace ZenBox\Form;

interface FormValidator
{
    function validate($value, array $constrains): array;
}
