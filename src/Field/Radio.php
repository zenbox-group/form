<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;
use ZenBox\Form\FormRenderer;

final class Radio extends Field
{
    public array $options;

    public function __construct(FormRenderer $renderer, string $name, string $label, array $options)
    {
        parent::__construct($renderer, $name, $label);
        $this->options = $options;
    }

    function render(): string
    {
        return $this->renderer->radio($this);
    }
}
