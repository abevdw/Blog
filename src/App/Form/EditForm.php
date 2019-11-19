<?php

declare(strict_types=1);

namespace App\Form;

Use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class EditForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('edit-form');
    }

    public function init()
    {
        $this->add([
            'type'    => Text::class,
            'name'    => 'text',
            'options' => [
                'label' => 'Tekst ',
            ],
        ]);

        $this->add([
            'name' => 'Edit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Edit',
            ],
        ]);
    }

    Public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'text',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],

        ];
    }
}
