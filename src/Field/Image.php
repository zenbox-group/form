<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;
use ZenBox\Form\FormRenderer;

final class Image extends Field
{
    public string $accept;

    public function __construct(FormRenderer $renderer, string $name, string $label, string $accept = '')
    {
        parent::__construct($renderer, $name, $label);
        $this->accept = $accept;
    }

    function render(): string
    {
        return $this->renderer->image($this);
    }
}
