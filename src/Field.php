<?php

declare(strict_types=1);

namespace ZenBox\Form;

abstract class Field
{
    protected FormRenderer $renderer;
    public string $name;
    public string $label;
    public string $value;
    public string $placeholder;
    public string $autocomplete;
    public string $error;

    public function __construct(FormRenderer $renderer, string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
        $this->renderer = $renderer;
        $this->value = '';
        $this->placeholder = '';
        $this->autocomplete = '';
        $this->error = '';
    }

    public function hasError(): bool
    {
        return (bool)$this->error;
    }

    abstract function render(): string;

    public function __toString(): string
    {
        return $this->render();
    }
}
