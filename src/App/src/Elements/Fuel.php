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

class Fuel extends Element\Select implements InputProviderInterface
{

    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);
        $this->setFuelOptions();
    }

    protected function setFuelOptions()
    {
            $this->setValueOptions(
                [
                    'petrol'   => 'Petrol',
                    'diesel'   => 'Diesel',
                    'hybrid'   => 'Hybrid',
                    'electric' => 'Electric',
                    'hydrogen' => 'Hydrogen Fuel Cell'
                ]
            );
    }

    protected $label = 'Fuel Type';

    /** @var  ValidatorInterface */
    protected $validator;

    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new Validator\ValidatorChain();
            $this->validator->attach(new Validator\NotEmpty());
        }
        return $this->validator;
    }
}