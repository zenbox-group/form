<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;

final class Password extends Field
{
    /**
     * @return string
     */
    function render(): string
    {
        return $this->renderer->password($this);
    }
}
