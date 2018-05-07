<?php
/**
 * User: kevin
 * Date: 28/04/2018
 * Time: 06:04
 */

namespace App\Auth;

use function json_decode;
use Zend\Authentication\Result;
use Zend\Authentication\Adapter\AdapterInterface;
use GuzzleHttp;


class AuthAdapter implements AdapterInterface
{
    private $password;
    private $username;
    private $spxClient;

    public function __construct
    (
        GuzzleHttp\ClientInterface $spxClient
    ) {
        $this->spxClient = $spxClient;
    }

    public function setPassword(string $password) : void
    {
        $this->password = $password;
    }

    public function setUsername(string $username) : void
    {
        $this->username = $username;
    }

    /**
     * Performs an authentication attempt
     *
     * @return Result
     */
    public function authenticate()
    {
        // Retrieve the user's information (e.g. from a database)
        // and store the result in $row (e.g. associative array).
        // If you do something like this, always store the passwords using the
        // PHP password_hash() function!


        $auth = $this->getAuth();
        if (!empty($auth)) {
            if (password_verify($this->password, $auth['password'])) {
                return new Result(Result::SUCCESS, $auth);
            }
        }
        return new Result(Result::FAILURE_CREDENTIAL_INVALID, $this->username);
    }

    private function getAuth()
    {
        $ret = [];
        $username = $this->username;

       try {
            $ret = json_decode($this->spxClient->request('GET', "getuserauth/$username")->getBody(), true);

        } catch (GuzzleHttp\Exception\GuzzleException $exception) {
            //TODO log exception
        }

        return $ret;
    }
}