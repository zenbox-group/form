<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;
use ZenBox\Form\FormRenderer;

final class File extends Field
{
    public string $accept;

    public function __construct(FormRenderer $renderer, string $name, string $label, string $accept = '')
    {
        parent::__construct($renderer, $name, $label);
        $this->accept = $accept;
    }

    function render(): string
    {
        return $this->renderer->file($this);
    }
}
