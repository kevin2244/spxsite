<?php
/**
 * @copyright Kevin Smith 2019
 * Date: 01/01/2019
 * Time: 12:51
 */

declare(strict_types=1);

namespace App\Forms;

use Zend\Form\Element;
use Zend\Form\Form;
use Zend\InputFilter\FileInput;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class AddPhotosForm extends Form
{
    public function __construct($name = null, array $options = [])
    {
        parent::__construct();

        $imageUploadDir = $options['image_upload_dir'];

        $this->add([
            'name' => 'image1',
            'options' => ['label' => 'Find Car Photo'],
            'type' => Element\File::class
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Add This Photo',
            ],
        ]);

        $this->add([
            'name' => 'form-name-id',
            'type' => 'Hidden',
            'attributes' => [
                'value' => 'add-photo'
            ],
        ]);

        $inputFilter = new InputFilter();
        $fileFilter = new FileInput('image1');

        $fileFilter->getValidatorChain()
            ->attach(new Validator\File\IsImage())
            ->attach(new Validator\File\Size(['min' => '1kB', 'max'=>'3MB']));

        $fileFilter->getFilterChain()->attachByName(
            'filerenameupload',
            [
                'target'    => $imageUploadDir .'/some-image.jpeg',
                'randomize' => true,
            ]
        );

        $inputFilter->add($fileFilter);
        $this->setInputFilter($inputFilter);
    }
}
