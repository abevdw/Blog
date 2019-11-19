<?php

declare(strict_types=1);

namespace App\Form;

Use Zend\Form\Element\Password;
Use Zend\Form\Element\Text;
use Zend\Form\Form;
use Zend\InputFilter\InputFilterProviderInterface;

class LoginForm extends Form implements InputFilterProviderInterface
{
    public function __construct()
    {
        parent::__construct('login-form');
    }

    public function init()
    {
        $this->add([
            'type'    => Text::class,
            'name'    => 'username',
            'options' => [
                'label' => 'Username: ',
            ],
        ]);

        $this->add([
            'type' => Password::class,
            'name' => 'password',
            'options' => [
                'label' => ' Password: ',
            ],
        ]);

        $this->add([
            'name' => 'Login',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Login',
            ],
        ]);
    }

    Public function getInputFilterSpecification()
    {
        return [
            [
                'name' => 'username',
                'required' => true,
                'filters' => [
                    ['name' => 'StripTags'],
                    ['name' => 'StringTrim'],
                ],
            ],

            [
                'name' => 'password',
                'required' => true,
                'filters' => [
                  ['name' => 'StripTags'],
                  ['name' => 'StringTrim'],
                ],
            ],
        ];
    }
}
