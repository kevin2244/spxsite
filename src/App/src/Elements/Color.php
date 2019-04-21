<?php
/**
 * @copyright Kevin Smith 2019
 * Date: 10/04/2019
 * Time: 21:09
 */
declare(strict_types = 1);

namespace App\Elements;

use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator;
use Zend\Validator\ValidatorInterface;

class Color extends Element implements InputProviderInterface
{

    protected $attributes = [
        'type' => 'text'
    ];

    protected $label = 'Colour';

    /** @var  ValidatorInterface */
    protected $validator;

    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new Validator\ValidatorChain();
            $this->validator->attach((new Validator\NotEmpty()))
                ->attach(new Validator\StringLength(['min' => 1, 'max => 64']))
                ->attach(new Validator\Regex(['pattern' =>'/^[a-z0-9 ,.\'\-–—]+$/i']));

        }
        return $this->validator;
    }


    public function getInputSpecification()
    {

        return [
            'name' => $this->getName(),
            'validators' => [
                $this->getValidator()
            ]
        ];
    }
}