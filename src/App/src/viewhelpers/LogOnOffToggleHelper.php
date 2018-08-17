<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\viewhelpers;

use Zend\Authentication\AuthenticationServiceInterface;


class LogOnOffToggleHelper
{
    private $serverUrl;
    private $url;
    private $authenticationService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService,
        $serverUrl,
        $url
    ) {
        $this->authenticationService = $authenticationService;
        $this->serverUrl = $serverUrl;
        $this->url = $url;
    }

    public function __invoke()
    {
        if ($this->authenticationService->hasIdentity()) {


            $helper=$this->serverUrl;
            $url=$this->url;
            $logoff = $helper($url('log-off'));

            $toggle =<<<EOF
            <a href="$logoff" class="nav-link">
            Log Off:
            </a>
EOF;
        }
        else {

            $helper=$this->serverUrl;
            $url=$this->url;
            $logon = $helper($url('log-on'));

            $toggle =<<<EOF
            <a href="$logon" class="nav-link">
            Log On
            </a>
EOF;
        }
        return $toggle;
    }
}