<?php declare(strict_types=1);

namespace App\Handler;

use App\Form\EditForm;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Container\ContainerInterface;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Form\FormElementManager;

class EditPageFactory
{
    public function __invoke(ContainerInterface $container) : MiddlewareInterface
    {
        $template  = $container->get(TemplateRendererInterface::class);
        $editForm = $container->get(FormElementManager::class)
                               ->get(EditForm::class);

        return new EditPageHandler($template, $editForm);
    }
}