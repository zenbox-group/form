# ZenBox Form

[![PHP Version](https://img.shields.io/packagist/php-v/zenbox/form.svg?style=for-the-badge)](https://packagist.org/packages/zenbox/form)
[![Stable Version](https://img.shields.io/packagist/v/zenbox/form.svg?style=for-the-badge&label=Latest)](https://packagist.org/packages/zenbox/form)
[![Total Downloads](https://img.shields.io/packagist/dt/zenbox/form.svg?style=for-the-badge&label=Total+downloads)](https://packagist.org/packages/zenbox/form)

Form HTML builder standalone component. Bootstrap 4 form renderer.

## Installation

Using Composer:

```sh
composer require zenbox/form
```

## Configuration

Use a dependency container for the FormBuilder configuration and inject FormBuilder into the HTTP request handler.

Describe the form renderer as a dependency:

```php
    public function getDependencies(): array
    {
        return [
            'aliases' => [
                ZenBox\Form\FormRenderer::class => ZenBox\Form\Renderer\Bootstrap4::class,
            ],
        ];
    }
```

## Instantiation

```php
<?php
use Psr\Container\ContainerInterface;
use ZenBox\Form\FormBuilder;

/** @var ContainerInterface $container */
// Get from container or inject into the HTTP request handler
$formBuilder = $container->get(FormBuilder::class);
// Create new form
$form = $formBuilder->create()
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

namespace ZenBox\Group\Infrastructure\UserInterface\RequestHandler;

use Laminas\Diactoros\Response\HtmlResponse;
use Laminas\Diactoros\Response\RedirectResponse;
use Mezzio\Authentication\AuthenticationInterface;
use Mezzio\Helper\UrlHelper;
use Mezzio\Template\TemplateRendererInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ZenBox\Form\FormBuilder;
use ZenBox\Group\Application\Command\User\RegistrationUserCommand;
use ZenBox\Group\Application\Command\User\RegistrationUserCommandHandler;
use ZenBox\Group\Infrastructure\Assert\Assert;
use ZenBox\Group\Infrastructure\Assert\LazyAssertionException;

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
            ->text('name', 'Name')
            ->text('email', 'Email')
            ->password('password', 'Password')->autocomplete('new-password')
            ->submit('Registration')
            ->build();

        if ($data = $request->getParsedBody()) {
            try {
                $form->setData($data);
                $command = new RegistrationUserCommand($data);

                Assert::lazy()
                    ->that($command->email, 'name')
                    ->notEmpty('Empty Name')
                    ->that($command->email, 'email')
                    ->notEmpty('Empty Email')
                    ->that($command->password, 'password')
                    ->notEmpty('Empty Password')
                    ->verifyNow();

                $this->registrationUserCommandHandler->handle($command);
                $this->authentication->authenticate($request);

                return new RedirectResponse($this->urlHelper->generate('login-success'));
            } catch (LazyAssertionException $exception) {
                $form->setErrors($exception->toArray());
            }
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
/** @var $form Form */
// entire form
use ZenBox\Form\Form;echo $form;
// separate elements
echo $form->getField('email');
```
