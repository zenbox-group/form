<?php

declare(strict_types=1);

namespace ZenBox\Form\Field;

use ZenBox\Form\Field;
use ZenBox\Form\Form;

final class File extends Field
{
    public string $accept;

    public function __construct(string $name, string $label, string $accept = '')
    {
        parent::__construct($name, $label);
        $this->accept = $accept;
    }

    function render(): string
    {
        return Form::$renderer->file($this);
    }
}
