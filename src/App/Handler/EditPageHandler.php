<?php

declare(strict_types=1);

namespace App\Handler;

use App\Form\EditForm;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Template\TemplateRendererInterface;

class EditPageHandler implements MiddlewareInterface
{
    private $template;
    private $editForm;

    public function __construct(TemplateRendererInterface $template, EditForm $editForm)
    {
        $this->template = $template;
        $this->editForm = $editForm;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);

//        if ($session->has(UserInterface::class))
//        {
//            return new RedirectResponse('/blog2/public/edit');
//        }

            if ($request->getMethod() === 'POST')
            {
                $this->editForm->setData($request->getParsedBody());
                if ($this->editForm->isValid())
                {
                    //?
                }
             }

//        else
//        {
//            return new RedirectResponse('/blog2/public/login');
//        }

        return new HtmlResponse(
            $this->template->render('app::edit-page', [
                'form' => $this->editForm,
            ])
        );
    }
}