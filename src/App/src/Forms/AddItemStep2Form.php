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

class AddItemStep2Form extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add(new Elements\Color('color'));
        $this->add(new Elements\Doors('doors'));
        $this->add(new Elements\Fuel('fuel'));
        $this->add(new Elements\Transmission('transmission'));

        $this->add([
            'name' => 'postid',
            'type' => 'hidden',
            'attributes' => [
                'value' => 'addacar-step2',
            ],
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Next',
            ],
        ]);
    }
}
