<?php
/**
 * User: kevin
 * Date: 01/05/2018
 * Time: 20:14
 */

namespace App\Forms;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

class LogonForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct();


        //add username
        //not empty, required, max 64 chars
        $this->add([
            'name' => 'username',
            'type' => Element\Text::class,
            'options' => [
                'label' => 'Username',
            ],
            'attributes' => [
                'placeholder' => 'Username',
            ]
        ]);

        //add password
        //required, max 64 chars
        $this->add([
            'name' => 'password',
            'type' => Element\Password::class,
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'placeholder' => 'Password',
            ]
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Go',
            ],
        ]);

        $inputFilter = new InputFilter();

        $usernameFilter = new Input('username');
        $usernameFilter->getValidatorChain()
                ->attach(new Validator\NotEmpty())
                ->attach(new Validator\StringLength(['max' => 32]));

        $passwordFilter = new Input('password');
        $passwordFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['max' => 32]));

        $inputFilter->add($usernameFilter)
            ->add($passwordFilter);

        $this->setInputFilter($inputFilter);

    }
}