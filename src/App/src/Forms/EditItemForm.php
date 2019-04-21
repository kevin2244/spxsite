<?php
/**
 * @copyright Kevin Smith 2019
 * Date: 13/01/2019
 * Time: 18:10
 */
declare(strict_types = 1);

namespace App\Forms;

use Zend\Form\Element;

class EditItemForm extends AddItemForm
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        /** @var  $element Element*/
        foreach ($this->getElements() as $element) {
            if ($element->getName() === 'send') {
                $element->setAttributes(['value'=> 'Save Changes']);
            }
        }

        $this->add([
            'name' => 'form-name-id',
            'type' => 'hidden',
            'attributes' => [
                'value' => 'edit-item',
            ],
        ]);

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
    }
}
