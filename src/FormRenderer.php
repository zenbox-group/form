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
use ZenBox\Form\Field\Textarea;

interface FormRenderer
{
    public function form(Form $form): string;

    public function open(Form $form): string;

    public function close(Form $form): string;

    public function text(Text $field): string;

    public function password(Password $field): string;

    public function submit(Submit $field): string;

    public function select(Select $field): string;

    public function file(File $field): string;

    public function image(Image $field): string;

    public function hidden(Hidden $field): string;

    public function textarea(Textarea $field): string;

    public function checkbox(Checkbox $field): string;

    public function radio(Radio $field): string;
}
