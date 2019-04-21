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

class Transmission extends Element\Select implements InputProviderInterface
{

    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);
        $this->setDoorOptions();
    }

    protected function setDoorOptions()
    {
            $this->setValueOptions(
                [
                    'manual'    => 'Manual',
                    'automatic' => 'Automatic'
                ]
            );
    }

    protected $label = 'Transmission';

    /** @var  ValidatorInterface */
    protected $validator;

    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new Validator\ValidatorChain();
            $this->validator->attach(new Validator\NotEmpty())
                ->attach(new Validator\StringLength(['min' => 1, 'max => 64']));
        }
        return $this->validator;
    }
}
