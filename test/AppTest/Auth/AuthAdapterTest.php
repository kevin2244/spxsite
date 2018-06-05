<?php

namespace AppTest\Auth;

use App\Auth\AuthAdapter;

use const PASSWORD_DEFAULT;
use function password_hash;
use PHPUnit;

class AuthAdapterTest extends PHPUnit\Framework\TestCase
{

    public  function testAuthenticateValid()
    {
        //set up
        $userInputUsername =  'SomeUsername';
        $userInputPassword = 'Password1';
        $storedPassword = password_hash('Password1',PASSWORD_DEFAULT);
        $storeReposnse = new \GuzzleHttp\Psr7\Response(200,[],'{"username":"SomeUsername","password":"'. $storedPassword .'","verified" : true}');

        //prophecy
        $prophecy = $this->prophesize(\GuzzleHttp\ClientInterface::class);
        $prophecy->request("GET", "getuserauth/SomeUsername")->willReturn($storeReposnse);

        //test authentication
        $authAdapter = new AuthAdapter($prophecy->reveal());
        $authAdapter->setUsername($userInputUsername);
        $authAdapter->setPassword($userInputPassword);

        $this->assertTrue($authAdapter->authenticate()->isValid());
    }

    public function testAuthenticateUnverifiedIsNotValid()
    {
        //set up
        $userInputUsername =  'SomeUsername';
        $userInputPassword = 'Password1';
        $storedPassword = password_hash('Password1',PASSWORD_DEFAULT);
        $storeReposnse = new \GuzzleHttp\Psr7\Response(200,[],'{"username":"SomeUsername","password":"'. $storedPassword .'","verified" : false}');

        //prophecy
        $prophecy = $this->prophesize(\GuzzleHttp\ClientInterface::class);
        $prophecy->request("GET", "getuserauth/SomeUsername")->willReturn($storeReposnse);

        //test authentication
        $authAdapter = new AuthAdapter($prophecy->reveal());
        $authAdapter->setUsername($userInputUsername);
        $authAdapter->setPassword($userInputPassword);

        $this->assertFalse($authAdapter->authenticate()->isValid());

    }

    public  function testAuthenticateIncorrectPasswordIsNotValid()
    {
        //set up
        $userInputUsername =  'SomeUsername';
        $userInputPassword = 'NotThePassword';
        $storedPassword = password_hash('Password1',PASSWORD_DEFAULT);
        $storeReposnse = new \GuzzleHttp\Psr7\Response(200,[],'{"username":"SomeUsername","password":"'. $storedPassword .'","verified":true}');

        //prophecy
        $prophecy = $this->prophesize(\GuzzleHttp\ClientInterface::class);
        $prophecy->request("GET", "getuserauth/SomeUsername")->willReturn($storeReposnse);

        //test authentication
        $authAdapter = new AuthAdapter($prophecy->reveal());
        $authAdapter->setUsername($userInputUsername);
        $authAdapter->setPassword($userInputPassword);

        $this->assertFalse($authAdapter->authenticate()->isValid());
    }
}
