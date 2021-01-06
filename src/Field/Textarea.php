<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;

final class Textarea extends Field
{
    function render(): string
    {
        $this->renderer->textarea($this);
    }
}
