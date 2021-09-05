<?php

declare(strict_types=1);

namespace ZenBox\Form;

abstract class Field
{
    public string $name;
    public string $label;
    public string $value;
    public string $placeholder;
    public string $autocomplete;
    public array $errors;
    public array $constrains;

    public function __construct(string $name, string $label)
    {
        $this->name = $name;
        $this->label = $label;
        $this->value = '';
        $this->placeholder = '';
        $this->autocomplete = '';
        $this->errors = [];
        $this->constrains = [];
    }

    public function validate(): void
    {
        $this->errors = Form::$validator->validate($this->value, $this->constrains);
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    abstract function render(): string;

    public function __toString(): string
    {
        return $this->render();
    }
}
