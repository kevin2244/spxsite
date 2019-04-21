<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\Forms;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\I18n;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Validator;

class RegistrationForm extends Form
{

    public function __construct($name = null, array $options = [])
    {
        parent::__construct($name, $options);




        $this->add([
            'name' => 'username',
            'type' => Element\Text::class,

            'options' => [
                'label' => 'Choose Username',
            ],
            'attributes' => [
                'placeholder' => 'Username',
            ]
        ]);

        $this->add([
            'name' => 'password',
            'type' => Element\Password::class,
            'options' => [
                'label' => 'Choose Password',
            ],
            'attributes' => [
                'placeholder' => 'Password',
            ]
        ]);

        $this->add([
            'type' => Element\Email::class,
            'name' => 'email',
            'options' => [
                'label' => 'Email'
            ]
        ]);

        $this->add([
            'name' => 'send',
            'type'  => 'Submit',
            'attributes' => [
                'value' => 'Go',
            ],
        ]);

        $this->add([
            'name' => 'firstname',
            'type' => Element\Text::class,
            'options' => ['label' => 'First name'],
            'attributes' => ['placeholder' => 'First name'],
        ]);

        $this->add([
            'name' => 'lastname',
            'type' => Element\Text::class,
            'options' => ['label' => 'Last name'],
            'attributes' => ['placeholder' => 'Last name'],
        ]);

        $this->add([
            'name' => 'address_first_line',
            'type' => Element\Text::class,
            'options' => ['label' => 'House name/number and street'],
            'attributes' => ['placeholder' => 'address_first_line'],
        ]);

        $this->add([
            'name' => 'address_second_line',
            //'required' => false,
            'type' => Element\Text::class,
            'options' => ['label' => 'Second line of address'],
            'attributes' => ['placeholder' => 'address_second_line'],
        ]);

        $this->add([
            'name' => 'post_town',
            'type' => Element\Text::class,
            'options' => ['label' => 'Post town or city'],
            'attributes' => ['placeholder' => 'Post Town'],
        ]);

        $this->add([
            'name' => 'post_code',
            'type' => Element\Text::class,
            'options' => ['label' => 'Post Code'],
            'attributes' => ['placeholder' => 'Post Code'],
        ]);


        $this->add([
            'name' => 'county',
            'type' => Element\Select::class,
            'options' => [
                'label' => 'County',
                'value_options' => [
                    'England' => [
                        'label' => 'England',
                        'options' => [
                            'Bedfordshire' => 'Bedfordshire',
                            'Berkshire' => 'Berkshire',
                            'Bristol' => 'Bristol',
                            'Buckinghamshire' => 'Buckinghamshire',
                            'Cambridgeshire' => 'Cambridgeshire',
                            'Cheshire' => 'Cheshire',
                            'City of London' => 'City of London',
                            'Cornwall' => 'Cornwall',
                            'Cumbria' => 'Cumbria',
                            'Derbyshire' => 'Derbyshire',
                            'Devon' => 'Devon',
                            'Dorset' => 'Dorset',
                            'Durham' => 'Durham',
                            'East Riding of Yorkshire' => 'East Riding of Yorkshire',
                            'East Sussex' => 'East Sussex',
                            'Essex' => 'Essex',
                            'Gloucestershire' => 'Gloucestershire',
                            'Greater London' => 'Greater London',
                            'Greater Manchester' => 'Greater Manchester',
                            'Hampshire' => 'Hampshire',
                            'Herefordshire' => 'Herefordshire',
                            'Hertfordshire' => 'Hertfordshire',
                            'Isle of Wight' => 'Isle of Wight',
                            'Kent' => 'Kent',
                            'Lancashire' => 'Lancashire',
                            'Leicestershire' => 'Leicestershire',
                            'Lincolnshire' => 'Lincolnshire',
                            'Merseyside' => 'Merseyside',
                            'Norfolk' => 'Norfolk',
                            'North Yorkshire' => 'North Yorkshire',
                            'Northamptonshire' => 'Northamptonshire',
                            'Northumberland' => 'Northumberland',
                            'Nottinghamshire' => 'Nottinghamshire',
                            'Oxfordshire' => 'Oxfordshire',
                            'Rutland' => 'Rutland',
                            'Shropshire' => 'Shropshire',
                            'Somerset' => 'Somerset',
                            'South Yorkshire' => 'South Yorkshire',
                            'Staffordshire' => 'Staffordshire',
                            'Suffolk' => 'Suffolk',
                            'Surrey' => 'Surrey',
                            'Tyne and Wear' => 'Tyne and Wear',
                            'Warwickshire' => 'Warwickshire',
                            'West Midlands' => 'West Midlands',
                            'West Sussex' => 'West Sussex',
                            'West Yorkshire' => 'West Yorkshire',
                            'Wiltshire' => 'Wiltshire',
                            'Worcestershire' => 'Worcestershire'
                        ],
                    ],
                    'Scotland' => [
                        'label' => 'Scotland',
                        'options' => [
                            'Aberdeenshire' => 'Aberdeenshire',
                            'Angus' => 'Angus',
                            'Argyllshire' => 'Argyllshire',
                            'Ayrshire' => 'Ayrshire',
                            'Banffshire' => 'Banffshire',
                            'Berwickshire' => 'Berwickshire',
                            'Buteshire' => 'Buteshire',
                            'Cromartyshire' => 'Cromartyshire',
                            'Caithness' => 'Caithness',
                            'Clackmannanshire' => 'Clackmannanshire',
                            'Dumfriesshire' => 'Dumfriesshire',
                            'Dunbartonshire' => 'Dunbartonshire',
                            'East Lothian' => 'East Lothian',
                            'Fife' => 'Fife',
                            'Inverness-shire' => 'Inverness-shire',
                            'Kincardineshire' => 'Kincardineshire',
                            'Kinross' => 'Kinross',
                            'Kirkcudbrightshire' => 'Kirkcudbrightshire',
                            'Lanarkshire' => 'Lanarkshire',
                            'Midlothian' => 'Midlothian',
                            'Morayshire' => 'Morayshire',
                            'Nairnshire' => 'Nairnshire',
                            'Orkney' => 'Orkney',
                            'Peeblesshire' => 'Peeblesshire',
                            'Perthshire' => 'Perthshire',
                            'Renfrewshire' => 'Renfrewshire',
                            'Ross-shire' => 'Ross-shire',
                            'Roxburghshire' => 'Roxburghshire',
                            'Selkirkshire' => 'Selkirkshire',
                            'Shetland' => 'Shetland',
                            'Stirlingshire' => 'Stirlingshire',
                            'Sutherland' => 'Sutherland',
                            'West Lothian' => 'West Lothian',
                            'Wigtownshire' => 'Wigtownshire'
                        ]
                    ],
                    'Wales' => [
                        'label' => 'Wales',
                        'options' => [
                            'Anglesey' => 'Anglesey',
                            'Brecknockshire' => 'Brecknockshire',
                            'Caernarfonshire' => 'Caernarfonshire',
                            'Carmarthenshire' => 'Carmarthenshire',
                            'Cardiganshire' => 'Cardiganshire',
                            'Denbighshire' => 'Denbighshire',
                            'Flintshire' => 'Flintshire',
                            'Glamorgan' => 'Glamorgan',
                            'Merioneth' => 'Merioneth',
                            'Monmouthshire' => 'Monmouthshire',
                            'Montgomeryshire' => 'Montgomeryshire',
                            'Pembrokeshire' => 'Pembrokeshire',
                            'Radnorshire' => 'Radnorshire'
                        ]
                    ],
                    'Northern Ireland' => [
                        'label' => 'Northern Ireland',
                        'options' => [
                            'Antrim' => 'Antrim',
                            'Armagh' => 'Armagh',
                            'Down' => 'Down',
                            'Fermanagh' => 'Fermanagh',
                            'Londonderry' => 'Londonderry',
                            'Tyrone' => 'Tyrone',
                        ]
                    ]
                 ],
            ]
        ]);

        $this->add([
           'type' => Element\Tel::class,
           'name' => 'phone',
           'options' => [
               'label' => 'Telephone'
           ]
        ]);

        $recaptureOptions = [
            'secret_key' => $options['recapture_config']['secret_key'],
            'site_key' => $options['recapture_config']['site_key']
        ];

        $this->add([
            'name' => 'g-recaptcha-response',
            'type' => Element\Captcha::class,
            'options' => [
                'label' => 'Please verify you are human',
                'captcha' => new Captcha\ReCaptcha($recaptureOptions)
            ],
        ]);

        $inputFilter = new InputFilter();

        $usernameFilter = new Input('username');
        $usernameFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['min' => 6, 'max' => 32]))
            ->attach(new I18n\Validator\Alnum());

        $passwordFilter = new Input('password');
        $passwordFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['max' => 32]));

        $postcodeFilter = new Input('post_code');
        $postcodeFilter->getValidatorChain()
            ->attach(new Validator\StringLength(['max' => 32]))
            ->attach(new I18n\Validator\PostCode(['locale' => 'en_GB']));

        $emailFilter = new Input('email');
        $emailFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\EmailAddress());

        $firstnameFilter = new Input('firstname');
        $firstnameFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['max' => 64]))
            ->attach(new Validator\Regex(['pattern' => '/^[a-z ,.\'-]+$/i']));

        $lastnameFilter = new Input('lastname');
        $lastnameFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['max' => 64]))
            ->attach(new Validator\Regex(['pattern' => '/^[a-z ,.\'-]+$/i']));

        $addressSecondLineFilter = new Input('address_second_line');
        $addressSecondLineFilter->setRequired(false);
        $addressSecondLineFilter->getValidatorChain()
            ->attach(new Validator\StringLength(['max' => 64]))
            ->attach(new Validator\Regex(['pattern' =>'/^[a-z ,.\'-]+$/i']));

        $addressFirstLineFilter = new Input('address_first_line');
        $addressFirstLineFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['max' => 64]))
            ->attach(new Validator\Regex(['pattern' => '/^[a-z0-9 ,.\'-]+$/i']));

        $postTownFilter = new Input('post_town');
        $postTownFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['max' => 64]))
            ->attach(new Validator\Regex(['pattern' =>'/^[a-z0-9 ,.\'-]+$/i']));

        $countyFilter = new Input('county');
        $countyFilter->getValidatorChain()
            ->attach(new Validator\NotEmpty())
            ->attach(new Validator\StringLength(['max' => 32]))
            ->attach(new Validator\Regex(['pattern' => '/^[A-Za-z0-9- ]+$/']));

        $phoneFilter = new Input('phone');
        $phoneFilter->setRequired(false);
        $phoneFilter->getValidatorChain()
            ->attach(new Validator\StringLength(['max' => 32]))
            ->attach(new Validator\Regex(['pattern' => '/[0-9+\(\) ]/']));

        $inputFilter->add($usernameFilter)
            ->add($passwordFilter)
            ->add($postcodeFilter)
            ->add($emailFilter)
            ->add($postTownFilter)
            ->add($firstnameFilter)
            ->add($lastnameFilter)
            ->add($addressFirstLineFilter)
            ->add($addressSecondLineFilter)
            ->add($countyFilter)
            ->add($phoneFilter);

        $this->setInputFilter($inputFilter);
    }
}
