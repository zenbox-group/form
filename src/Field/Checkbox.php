<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;
use ZenBox\Form\Form;

final class Checkbox extends Field
{
    function render(): string
    {
        return Form::$renderer->checkbox($this);
    }
}
