<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;

final class Hidden extends Field
{
    function render(): string
    {
        return $this->renderer->hidden($this);
    }
}
