<?php

declare(strict_types=1);

namespace App\Handler;

use App\Form\EditForm;
use PDOException;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Authentication\UserInterface;
use Zend\Expressive\Session\SessionMiddleware;
use Zend\Expressive\Template\TemplateRendererInterface;
use PDO;

class EditPageHandler implements MiddlewareInterface
{
    private $template;
    private $editForm;
    private $text;

    public function __construct(TemplateRendererInterface $template, EditForm $editForm)
    {
        $this->template = $template;
        $this->editForm = $editForm;
        $this->text = isset($_POST['text']) ? $_POST['text'] : null;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $session = $request->getAttribute(SessionMiddleware::SESSION_ATTRIBUTE);
        if ($session->has(UserInterface::class))
        {
            $servername = "ip adress or localhost";
            $username = "Abe";
            $password = "xxxx";
            $pdo = new PDO("mysql:host=$servername;port=3306;dbname=test;", $username, $password);

            $parameters = array('');
            $sth = $pdo->prepare('select * from edit');
            $sth->execute($parameters);

            while ($row = $sth->fetch())
            {
                $description = $row['Description'];
            }

            if ($request->getMethod() === 'POST')
            {
                $this->editForm->setData($request->getParsedBody());
                if ($this->editForm->isValid())
                {
                    // update query
                    $parameters = array(':Description'=>$this->text);
                    $sth = $pdo->prepare('UPDATE edit SET Description=:Description');
                    $sth->execute($parameters);

                    $parameters2 = array('');
                    $sth2 = $pdo->prepare('select * from edit');
                    $sth2->execute($parameters2);

                    while ($row = $sth2->fetch())
                    {
                        $description = $row['Description'];
                    }
                }
            }
        }
        else
        {
          return new RedirectResponse('/blog2/public/login');
        }

        return new HtmlResponse(
            $this->template->render('app::edit-page', [
                'form' => $this->editForm,
                'description' => $description,
            ])
        );
    }
}
