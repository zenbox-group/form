<?php

declare(strict_types=1);

namespace ZenBox\Form;

use ZenBox\Form\Field\Checkbox;
use ZenBox\Form\Field\File;
use ZenBox\Form\Field\Hidden;
use ZenBox\Form\Field\Image;
use ZenBox\Form\Field\Password;
use ZenBox\Form\Field\Radio;
use ZenBox\Form\Field\Select;
use ZenBox\Form\Field\Submit;
use ZenBox\Form\Field\Text;

final class FormBuilder
{
    private Form $form;
    private FormRenderer $renderer;
    private Field $currentField;

    public function __construct(FormRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function create(): FormBuilder
    {
        $builder = new static($this->renderer);
        $builder->form = new Form($this->renderer);

        return $builder;
    }

    public function text(string $name, string $label): self
    {
        $this->add(new Text($this->renderer, $name, $label));

        return $this;
    }

    public function password(string $name, string $label): self
    {
        $this->add(new Password($this->renderer, $name, $label));

        return $this;
    }

    public function checkbox(string $name, string $label): self
    {
        $field = new Checkbox($this->renderer, $name, $label);

        $this->add($field);

        return $this;
    }

    public function select(string $name, string $label, array $options): self
    {
        $field = new Select($this->renderer, $name, $label, $options);

        $this->add($field);

        return $this;
    }

    public function radio(string $name, string $label, array $options): self
    {
        $field = new Radio($this->renderer, $name, $label, $options);

        $this->add($field);

        return $this;
    }

    public function file(string $name, string $label, string $accept = ''): self
    {
        $this->add(new File($this->renderer, $name, $label, $accept));

        return $this;
    }

    public function image(string $name, string $label, string $accept = ''): self
    {
        $this->add(new Image($this->renderer, $name, $label, $accept));

        return $this;
    }

    public function hidden(string $name): self
    {
        $this->add(new Hidden($this->renderer, $name, ''));

        return $this;
    }

    public function submit(string $value): self
    {
        $this->add(new Submit($this->renderer, '', ''))->value($value);

        return $this;
    }

    public function value($value): self
    {
        $this->currentField->value = (string)$value;

        return $this;
    }

    public function placeholder(string $value): self
    {
        $this->currentField->placeholder = $value;

        return $this;
    }

    public function autocomplete(string $value): self
    {
        $this->currentField->autocomplete = $value;

        return $this;
    }

    public function build(): Form
    {
        return $this->form;
    }

    public function add(Field $field): self
    {
        $this->currentField = $field;
        $this->form->addField($field);

        return $this;
    }
}
