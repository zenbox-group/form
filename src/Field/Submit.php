<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;

final class Submit extends Field
{
    function render(): string
    {
        return $this->renderer->submit($this);
    }
}
