<?php

declare(strict_types=1);

namespace ZenBox\Form\Renderer;

use ZenBox\Form\Field;
use ZenBox\Form\Field\Checkbox;
use ZenBox\Form\Field\File;
use ZenBox\Form\Field\Hidden;
use ZenBox\Form\Field\Image;
use ZenBox\Form\Field\Password;
use ZenBox\Form\Field\Radio;
use ZenBox\Form\Field\Select;
use ZenBox\Form\Field\Submit;
use ZenBox\Form\Field\Text;
use ZenBox\Form\Field\Textarea;
use ZenBox\Form\Form;
use ZenBox\Form\FormRenderer;

final class Bootstrap4 implements FormRenderer
{
    public function form(Form $form): string
    {
        $html = $this->open($form);

        /** @var Field $field */
        foreach ($form->getIterator() as $field) {
            $html .= $field->render();
        }

        $html .= $this->close($form);

        return $html;
    }

    public function open(Form $form): string
    {
        return '<form enctype="multipart/form-data" class="needs-validation" method="post" novalidate>';
    }

    public function close(Form $form): string
    {
        return '</form>';
    }

    public function text(Text $field): string
    {
        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }

        return <<<HTML
<div class="form-group">
<label for="{$field->name}">{$field->label}</label>
<input type="text" class="{$class}" id="{$field->name}" placeholder="{$field->placeholder}" autocomplete="{$field->autocomplete}" name="{$field->name}" value="{$field->value}">
{$errorHtml}
</div>
HTML;
    }

    public function password(Password $field): string
    {
        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }

        return <<<HTML
<div class="form-group">
<label for="{$field->name}">{$field->label}</label>
<input type="password" class="{$class}" id="{$field->name}" placeholder="{$field->placeholder}" autocomplete="{$field->autocomplete}" name="{$field->name}" value="{$field->value}">
{$errorHtml}
</div>
HTML;
    }

    public function submit(Submit $field): string
    {
        return <<<HTML
<button class="btn btn-primary" type="submit">{$field->value}</button>
HTML;
    }

    public function select(Select $field): string
    {
        $optionsHtml = '';

        foreach ($field->options as $value => $name) {
            $selected = $value == $field->value ? ' selected' : '';

            $optionsHtml .= '<option' . $selected . ' value="' . $value . '">' . $name . '</option>';
        }

        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }

        return <<<HTML
<div class="form-group">
<label for="{$field->name}">{$field->label}</label>
<select class="{$class}" id="{$field->name}" name="{$field->name}">
{$optionsHtml}
</select>
{$errorHtml}
</div>
HTML;
    }

    public function file(File $field): string
    {
        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }

        return <<<HTML
<div class="form-group">
<label for="{$field->name}">{$field->label}</label>
<input type="file" class="{$class}" id="{$field->name}" placeholder="{$field->placeholder}" autocomplete="{$field->autocomplete}" name="{$field->name}" value="{$field->value}" accept="{$field->accept}">
{$errorHtml}
</div>
HTML;
    }

    public function image(Image $field): string
    {
        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }

        return <<<HTML
<div class="form-group">
<label for="{$field->name}">{$field->label}</label>
<input type="file" class="{$class}" id="{$field->name}" placeholder="{$field->placeholder}" autocomplete="{$field->autocomplete}" name="{$field->name}" value="{$field->value}" accept="{$field->accept}">
<img style="max-width: 300px;margin-top: 15px;border: 1px solid #ced4da;border-radius: .25rem" src="{$field->value}" alt="">
{$errorHtml}
</div>
HTML;
    }

    public function hidden(Hidden $field): string
    {
        return <<<HTML
<input type="hidden" name="{$field->name}" value="{$field->value}" data-error="{$field->error}">
HTML;
    }

    public function textarea(Textarea $field): string
    {
        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }

        return <<<HTML
<div class="form-group">
<label for="{$field->name}">{$field->label}</label>
<textarea class="{$class}" id="{$field->name}" placeholder="{$field->placeholder}" autocomplete="{$field->autocomplete}" name="{$field->name}">{$field->value}</textarea>
{$errorHtml}
</div>
HTML;
    }

    public function checkbox(Checkbox $field): string
    {
        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }
        $selected = !empty($field->value) ? ' checked' : '';

        return <<<HTML
<div class="form-group form-check">
<input type="checkbox" class="form-check-input{$class}" name="{$field->name}" id="{$field->name}"{$selected}>
<label class="form-check-label" for="{$field->name}">{$field->label}</label>
{$errorHtml}
</div>
HTML;
    }

    public function radio(Radio $field): string
    {
        $optionsHtml = '';

        foreach ($field->options as $value => $name) {
            $selected = $value == $field->value ? ' checked' : '';

            $optionsHtml .= '<div class="form-check">
  <input class="form-check-input" type="radio" name="' . $field->name . '" id="' . $field->name . '-' . $name . '" value="' . $value . '"' . $selected . '>
  <label class="form-check-label" for="' . $field->name . '-' . $name . '">' . $name . '</label>
</div>';
        }

        $errorHtml = '';
        $class = 'form-control';
        if ($field->hasError()) {
            $errorHtml = '<div class="invalid-feedback">' . $field->error . '</div>';
            $class .= ' is-invalid';
        }

        return <<<HTML
<div class="form-group">
<label>{$field->label}</label>
{$optionsHtml}
{$errorHtml}
</div>
HTML;
    }
}
