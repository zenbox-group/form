<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;
use ZenBox\Form\Form;

final class Select extends Field
{
    public array $options;

    public function __construct(string $name, string $label, array $options)
    {
        parent::__construct($name, $label);
        $this->options = $options;
    }

    function render(): string
    {
        return Form::$renderer->select($this);
    }
}
