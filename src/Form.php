<?php

declare(strict_types=1);

namespace ZenBox\Form;

use ArrayIterator;
use IteratorAggregate;
use Psr\Http\Message\ServerRequestInterface;

final class Form implements IteratorAggregate
{
    public static FormRenderer $renderer;
    public static FormValidator $validator;
    public string $method;
    /** @var ArrayIterator|Field[] */
    private ArrayIterator $fields;
    private bool $isSubmitted;

    public static function configuration(FormRenderer $renderer, FormValidator $validator): void
    {
        self::$renderer = $renderer;
        self::$validator = $validator;
    }

    public function __construct()
    {
        $this->fields = new ArrayIterator();
        $this->methodPost();
        $this->isSubmitted = false;
    }

    public function methodPost()
    {
        $this->method = 'post';
    }

    public function methodGet()
    {
        $this->method = 'get';
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
            if (isset($data[$name])) {
                $field->value = (string)$data[$name];
                $this->isSubmitted = true;
            }
        }
    }

    public function getData(): array
    {
        $data = [];

        foreach ($this->fields as $name => $field) {
            $data[$name] = $field->value;
        }

        return $data;
    }

    public function getErrors(): array
    {
        $errors = [];
        foreach ($this->fields as $name => $field) {
            if ($field->hasErrors()) {
                $errors[$name] = $field->errors;
            }
        }

        return $errors;
    }

    public function setErrors(array $errors): void
    {
        foreach ($this->fields as $name => $field) {
            if (isset($errors[$name]) && is_array($errors[$name])) {
                $field->errors = $errors[$name];
            }
        }
    }

    public function getIterator()
    {
        return $this->fields;
    }

    public function render(): string
    {
        return Form::$renderer->form($this);
    }

    public function validate(): void
    {
        foreach ($this->fields as $field) {
            $field->validate();
        }
    }

    public function isValid(): bool
    {
        foreach ($this->fields as $field) {
            if ($field->hasErrors()) {
                return false;
            }
        }

        return true;
    }

    public function isSubmitted(): bool
    {
        return $this->isSubmitted;
    }

    public function handleRequest(ServerRequestInterface $serverRequest): void
    {
        if ($this->method === 'get') {
            $data = $serverRequest->getQueryParams();
        } else {
            $data = $serverRequest->getParsedBody();
        }

        if (!empty($data) && is_array($data)) {
            $this->setData($data);
            $this->validate();
        }
    }

    public function __toString(): string
    {
        return $this->render();
    }
}
