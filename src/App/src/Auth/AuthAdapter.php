<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Auth;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;

class AuthAdapter implements AdapterInterface
{
    private $password;
    private $username;
    private $spxClient;

    public function __construct(
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

        $ret = new Result(
            Result::FAILURE_CREDENTIAL_INVALID,
            $this->username
        );



        if (!isset($auth['verified'])) {
            return $ret;
        }
        if ($auth['verified'] !== true) {
            return $ret;
        }
        if (!empty($auth['password'])) {
            if (password_verify($this->password, $auth['password'])) {
                $ret = new Result(Result::SUCCESS, $auth);
            }
        }
        return $ret;
    }

    private function getAuth()
    {
        $ret = [];
        $username = $this->username;

        try {
            $ret = json_decode(
                $this->spxClient->request(
                    'GET',
                    "getuserauth/$username"
                )->getBody()->getContents(),
                true
            );
        } catch (GuzzleException $e) {
            error_log(
                'GuzzleException' . $e->getMessage(),
                E_USER_ERROR
            );
        }
        return $ret;
    }
}
