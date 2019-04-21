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

class Phone extends Element implements InputProviderInterface
{

    protected $attributes = [
        'type' => 'tel'
    ];

    protected $label = 'Contact Phone Number';

    /** @var  ValidatorInterface */
    protected $validator;

    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new Validator\ValidatorChain();
            $this->validator->attach((new Validator\NotEmpty()))
                ->attach(new Validator\StringLength(['min' => 1, 'max => 32']))
                ->attach(new Validator\Regex(['pattern' =>'/^[0-9 \+]+$/i']));
        }
        return $this->validator;
    }


    public function getInputSpecification()
    {
        // TODO: Implement getInputSpecification() method.

        return [
            'name' => $this->getName(),
            'validators' => [
                $this->getValidator()
            ]
        ];
    }
}
