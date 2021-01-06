<?php

declare(strict_types=1);

namespace ZenBox\Form;

use ArrayIterator;
use IteratorAggregate;

final class Form implements IteratorAggregate
{
    private ArrayIterator $fields;
    private FormRenderer $renderer;

    public function __construct(FormRenderer $renderer)
    {
        $this->fields = new ArrayIterator();
        $this->renderer = $renderer;
    }

    public function addField(Field $field): void
    {
        $this->fields->offsetSet($field->name, $field);
    }

    public function getField(string $name): ?Field
    {
        return $this->fields->offsetGet($name);
    }

    public function setData(array $data): void
    {
        foreach ($this->fields as $name => $field) {
            if ($field instanceof Field && isset($data[$name])) {
                $field->value = (string)$data[$name];
            }
        }
    }

    public function setErrors(array $errors): void
    {
        /**
         * @var string $name
         * @var Field $field
         */
        foreach ($this->fields as $name => $field) {
            if (isset($errors[$name])) {
                $field->error = $errors[$name];
            }
        }
    }

    /**
     * Retrieve an external iterator
     * @link https://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return ArrayIterator An instance of an object implementing <b>Iterator</b> or
     * <b>Traversable</b>
     * @since 5.0.0
     */
    public function getIterator()
    {
        return $this->fields;
    }

    /**
     * @return FormRenderer
     */
    public function getRenderer(): FormRenderer
    {
        return $this->renderer;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->renderer->form($this);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->render();
    }
}
