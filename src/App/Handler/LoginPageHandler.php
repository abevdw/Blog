<?php

declare(strict_types=1);

namespace App\Handler;

use App\Form\LoginForm;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Template\TemplateRendererInterface;

class LoginPageHandler implements MiddlewareInterface
{
    private $template;
    private $loginForm;

    public function __construct(TemplateRendererInterface $template, LoginForm $loginForm)
    {
        $this->template  = $template;
        $this->loginForm = $loginForm;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

        if ($session->has(UserInterface::class)) {
            return new RedirectResponse('/blog2/public/edit');
        }

        $error = '';
        if ($request->getMethod() === 'POST')
        {

            $this->loginForm->setData($request->getParsedBody());
            if ($this->loginForm->isValid())
            {
                $response = $handler->handle($request);
             //  var_dump($response->getStatusCode());
             //  die;
                if ($response->getStatusCode() !== 302)
                {
                    return new RedirectResponse('/blog2/public/');
                }

                $error = 'Er is een fout opgetreden, probeer opnieuw in te loggen.';
            }
        }

        return new HtmlResponse(
            $this->template->render('app::login-page', [
                'form' => $this->loginForm,
                'error' => $error,
            ])
        );
    }
}
