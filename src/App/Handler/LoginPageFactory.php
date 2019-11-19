<?php
declare(strict_types=1);

namespace App\Handler;

use App\Form\LoginForm;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormElementManager;

class LoginPageFactory
{
   public function __invoke(ContainerInterface $container) : MiddlewareInterface
   {
       $template  = $container->get(TemplateRendererInterface::class);
       $loginForm = $container->get(FormElementManager::class)
                              ->get(LoginForm::class);

       return new LoginPageHandler($template, $loginForm);
   }
}
