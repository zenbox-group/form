<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;
use ZenBox\Form\Form;

final class Password extends Field
{
    function render(): string
    {
        return Form::$renderer->password($this);
    }
}
