<?php
/**
 * @copyright Kevin Smith 2019
 * Date: 14/04/2019
 * Time: 15:26
 */
declare(strict_types = 1);

namespace App\Forms;

use App\Elements;
use Zend\Form\Form;

class AddItemStep3Form extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add(new Elements\Price('price'));
        $this->add(new Elements\ItemLocation('item_location'));
        $this->add(new Elements\Phone('contact_phone'));
        $this->add(new Elements\Description('description'));

        $this->add([
            'name' => 'postid',
            'type' => 'hidden',
            'attributes' => [
                'value' => 'addacar-step3',
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Submit',
            ],
        ]);
    }
}
