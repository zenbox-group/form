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
    private Field $currentField;

    private function __construct()
    {

    }

    public static function create(): self
    {
        $builder = new self();
        $builder->form = new Form();

        return $builder;
    }

    public function methodPost(): self
    {
        $this->form->methodPost();

        return $this;
    }

    public function methodGet(): self
    {
        $this->form->methodGet();

        return $this;
    }

    public function text(string $name, string $label): self
    {
        $this->add(new Text($name, $label));

        return $this;
    }

    public function password(string $name, string $label): self
    {
        $this->add(new Password($name, $label));

        return $this;
    }

    public function checkbox(string $name, string $label): self
    {
        $field = new Checkbox($name, $label);

        $this->add($field);

        return $this;
    }

    public function select(string $name, string $label, array $options): self
    {
        $field = new Select($name, $label, $options);

        $this->add($field);

        return $this;
    }

    public function radio(string $name, string $label, array $options): self
    {
        $field = new Radio($name, $label, $options);

        $this->add($field);

        return $this;
    }

    public function file(string $name, string $label, string $accept = ''): self
    {
        $this->add(new File($name, $label, $accept));

        return $this;
    }

    public function image(string $name, string $label, string $accept = ''): self
    {
        $this->add(new Image($name, $label, $accept));

        return $this;
    }

    public function hidden(string $name): self
    {
        $this->add(new Hidden($name, ''));

        return $this;
    }

    public function submit(string $value): self
    {
        $this->add(new Submit('', ''))->value($value);

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

    public function constrains(object ...$constrains): self
    {
        $this->currentField->constrains = $constrains;

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
