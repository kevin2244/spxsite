<?php
/**
 * @copyright Kevin Smith 2019
 * Date: 14/04/2019
 * Time: 11:38
 */
declare(strict_types = 1);

namespace App\Elements;

use Zend\Form\Element;
use Zend\InputFilter\InputProviderInterface;
use Zend\Validator;
use Zend\Validator\ValidatorInterface;

class Mileage extends Element implements InputProviderInterface
{

    protected $attributes = [
        'type' => 'text'
    ];

    protected $label = 'Mileage';

    /** @var  ValidatorInterface */
    protected $validator;

    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new Validator\ValidatorChain();

            $this->validator->attach(new Validator\NotEmpty())
                ->attach(new Validator\StringLength(['min' => 1, 'max => 7']))
                ->attach(new Validator\Digits());
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