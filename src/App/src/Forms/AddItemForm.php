<?php
/**
 * @copyright Kevin Smith 2018
 * Date: 21/09/2018
 * Time: 12:21
 */
declare(strict_types=1);

namespace App\Forms;

use App\Elements;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\I18n;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class AddItemForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add(new Elements\Marque('marque'));
        $this->add(new Elements\Model('model'));
        $this->add(new Elements\YearFirstRegistration('year_first_registration'));
        $this->add(new Elements\Mileage('mileage'));


        $this->add([
            'name'    => 'item_location',
            'options' => ['label' => 'Vehicle location (City/Town/Area)'],
            'type'    => 'text',
        ]);

        $this->add([
            'name'    => 'contact_phone',
            'options' => ['label' => 'Contact Phone Number'],
            'type'    => 'text',
        ]);

        $this->add([
            'name'    => 'color',
            'options' => ['label' => 'Colour',],
            'type'    => 'text',
        ]);

        $this->add([
            'name'    => 'doors',
            'options' => [
                'label'         => 'Doors',
                'value_options' => [
                    '0' => '0',
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                    '5' => '5',
                ]
            ],
            'type'    => Element\Select::class,
        ]);

        $this->add([
            'name'    => 'fuel',
            'options' => [
                'label'         => 'Fuel Type',
                'value_options' => [
                    'petrol'   => 'Petrol',
                    'diesel'   => 'Diesel',
                    'hybrid'   => 'Hybrid',
                    'electric' => 'Electric',
                    'hydrogen' => 'Hydrogen Fuel Cell',
                ]
            ],
            'type'    => Element\Select::class,
        ]);


        $this->add([
            'name'    => 'transmission',
            'options' => [
                'label'         => 'Transmission',
                'value_options' => [
                    'manual'    => 'Manual',
                    'automatic' => 'Automatic'
                ]
            ],
            'type'    => Element\Select::class,
        ]);

        $this->add([
            'name'    => 'price',
            'options' => ['label' => 'Price £',],
            'type'    => 'text',
        ]);

        $this->add([
            'name'    => 'description',
            'options' => ['label' => 'Any Extra Description',],
            'type'    => 'text',
        ]);

        $this->add([
            'name' => 'postid',
            'type' => 'hidden',
            'attributes' => [
                'value' => 'addcar',
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Add Car',
            ],
        ]);


        $inputFilter = new InputFilter();



        $colorFilter = new Input('color');
        $colorFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 1, 'max => 64']))
            ->attach(new Validator\Regex(['pattern' =>'/^[a-z0-9 ,.\'\-–—]+$/i']));

        $doorsFilter = new Input('doors');
        $doorsFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 1, 'max => 1']))
            ->attach(new Validator\Digits());

        $fuelFilter = new Input('fuel');
        $fuelFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 1, 'max => 64']))
            ->attach(new I18n\Validator\Alnum());
        
        $priceFilter = new Input('price');
        $priceFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 1, 'max => 6']))
            ->attach(new Validator\Digits());

        $mileageFilter = new Input('mileage');
        $mileageFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 1, 'max => 7']))
            ->attach(new Validator\Digits());

        $itemLocationFilter = new Input('item_location');
        $itemLocationFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 1, 'max => 64']))
            ->attach(new Validator\Regex(['pattern' =>'/^[a-z0-9 ,.\'\-–—]+$/i']));

        $contactPhoneFilter = new Input('contact_phone');
        $contactPhoneFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 1, 'max => 32']))
            ->attach(new Validator\Regex(['pattern' =>'/^[0-9 \+]+$/i']));

        //this should be any string, no tags
        $descriptionFilter = new Input('description');
        $descriptionFilter->setRequired(false);
        $descriptionFilter->getValidatorChain()
            ->attach(new Validator\StringLength(['min' => 1, 'max => 1024']))
            ->attach(new Validator\Regex(['pattern' =>'/^[a-z0-9    ,.\'\-–—£\$\(\)]+$/i']));

        $inputFilter
            ->add($colorFilter)
            ->add($doorsFilter)
            ->add($fuelFilter)
            ->add($priceFilter)
            ->add($descriptionFilter)
            ->add($itemLocationFilter)
            ->add($contactPhoneFilter);

        $this->setInputFilter($inputFilter);
    }
}