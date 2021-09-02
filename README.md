# ZenBox Form

[![PHP Version](https://img.shields.io/packagist/php-v/zenbox/form.svg?style=for-the-badge)](https://packagist.org/packages/zenbox/form)
[![Stable Version](https://img.shields.io/packagist/v/zenbox/form.svg?style=for-the-badge&label=Latest)](https://packagist.org/packages/zenbox/form)
[![Total Downloads](https://img.shields.io/packagist/dt/zenbox/form.svg?style=for-the-badge&label=Total+downloads)](https://packagist.org/packages/zenbox/form)

Form HTML builder standalone component. Bootstrap 4 form renderer. Symfony or Laminas validation.

## Installation

Using Composer:

```sh
composer require zenbox/form
```

## Configuration

Use the static method for the rendering and validation configuration

```php
// or Bootstrap4 and Symfony Validator
Form::configuration(\ZenBox\Form\Renderer\Bootstrap4FormRenderer::class, \ZenBox\Form\Validator\SymfonyFormValidator::class);
// or Bootstrap4 and Laminas Validator
Form::configuration(\ZenBox\Form\Renderer\Bootstrap4FormRenderer::class, \ZenBox\Form\Validator\LaminasFormValidator::class);
```

## Instantiation

```php
<?php

use ZenBox\Form\FormBuilder;

// Create new form
$form = FormBuilder::create()
    ->text('name', 'Name')
    ->text('email', 'Email')
    ->password('password', 'Password')->autocomplete('new-password')
    ->submit('Registration')
    ->build();
    
// Set Data
$form->setData(['name' => 'User']);
// Set Errors
$form->setErrors(['password' => 'Password required']);
// Render form
echo $form;
// Render element
echo $form->getField('name');
```

## Examples

### PSR-7 Request Handler

```php
<?php

declare(strict_types=1);

namespace App\RequestHandler;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotCompromisedPassword;
use ZenBox\Form\FormBuilder;

final class RegistrationHandler implements RequestHandlerInterface
{
    private TemplateRendererInterface $templateRenderer;
    private FormBuilder $formBuilder;
    private RegistrationUserCommandHandler $registrationUserCommandHandler;
    private AuthenticationInterface $authentication;
    private UrlHelper $urlHelper;

    public function __construct(
        TemplateRendererInterface $templateRenderer,
        FormBuilder $formBuilder,
        RegistrationUserCommandHandler $registrationUserCommandHandler,
        AuthenticationInterface $authentication,
        UrlHelper $urlHelper
    )
    {
        $this->templateRenderer = $templateRenderer;
        $this->formBuilder = $formBuilder;
        $this->registrationUserCommandHandler = $registrationUserCommandHandler;
        $this->authentication = $authentication;
        $this->urlHelper = $urlHelper;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $form = $this->formBuilder->create()
            ->text('name', 'Name')->constrains(new NotBlank())
            ->text('email', 'Email')->constrains(new NotBlank(), new Email())
            ->password('password', 'Password')->autocomplete('new-password')->constrains(new NotCompromisedPassword())
            ->submit('Registration')
            ->build();
            
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get form data and registration user
            $data = $form->getData();
            // Registration user...
            return new RedirectResponse($this->urlHelper->generate('registration-success'));
        }

        return new HtmlResponse($this->templateRenderer->render('views::registration', [
            'form' => $form,
        ]));
    }
}
```

### Render Form

Twig Renderer

```twig
// entire form
{{ form|raw }}
// separate elements
{{ form.field('email')|raw }}
```

PHP Renderer

```php
<?php

use ZenBox\Form\Form;

/** @var $form Form */
// entire form
echo $form;
// separate elements
echo $form->getField('email');
```
