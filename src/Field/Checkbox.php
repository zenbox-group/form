<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;

final class Checkbox extends Field
{
    function render(): string
    {
        return $this->renderer->checkbox($this);
    }
}
