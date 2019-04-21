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

class  YearFirstRegistration extends Element\Select implements InputProviderInterface
{

    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);
        $this->setYearOptions();
    }

    protected function setYearOptions()
    {

            $yearOptions = [];

            $yearStart = 1890;
            $yearEnd= 2019;

            for ($y = $yearStart; $y <= $yearEnd; $y++) {
                $yearOptions[(string) $y] = (string)$y;
            }

            krsort($yearOptions);

            $this->setValueOptions( $yearOptions);
    }

    protected $label = 'Year First Registration';

    /** @var  ValidatorInterface */
    protected $validator;

    protected function getValidator()
    {
        if (null === $this->validator) {
            $this->validator = new Validator\ValidatorChain();
            $this->validator->attach(new Validator\NotEmpty())
                ->attach(new Validator\StringLength(['min' => 4, 'max' => 4]))
                ->attach(new Validator\Digits());
        }
        return $this->validator;
    }
}