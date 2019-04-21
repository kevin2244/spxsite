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

class AddItemStep1Form extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);

        $this->add(new Elements\Marque('marque'));
        $this->add(new Elements\Model('model'));
        $this->add(new Elements\YearFirstRegistration('year_first_registration'));
        $this->add(new Elements\Mileage('mileage'));

        $this->add([
            'name' => 'postid',
            'type' => 'hidden',
            'attributes' => [
                'value' => 'addacar-step1',
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
