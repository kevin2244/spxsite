<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Forms;
use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;
use Zend\I18n;

class SearchForm extends Form
{
    /**
     * SearchForm constructor.
     *
     * @param array $marquelist
     */
    public function __construct(array $marquelist = [])
    {
        parent::__construct();

        $formmarquelist = [];

        foreach($marquelist as $mkey => $mval) {

            $formmarquelist[$mval] = $mval;
        }

        $this->add([
            'name' => 'marque',
            'options' => [
                'label' => 'Marque',
                'value_options' => $formmarquelist
            ],
            'type' => Element\Select::class,
        ]);

        $this->add([
            'name' => 'text',
            'type' => Element\Text::class,
            'options' => [
                'label' => '',
            ],
            'attributes' => [
                'placeholder' => 'Search Text (optional)',
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Go',
            ],
        ]);

        $inputFilter = new InputFilter();

        $marqueInput = new Input('marque');
        $marqueInput->getValidatorChain()
                    ->attach(new Validator\NotEmpty())
                    ->attach(new Validator\StringLength(['max' => 32]));

        $textInput = new Input('text');
        $textInput->setRequired(false);
        $textInput->getValidatorChain()
                  ->attach(new Validator\StringLength(['max' => 32]))
                  ->attach(new I18n\Validator\Alnum(true));

        $inputFilter->add($marqueInput)
            ->add($textInput);

        $this->setInputFilter($inputFilter);
    }
}