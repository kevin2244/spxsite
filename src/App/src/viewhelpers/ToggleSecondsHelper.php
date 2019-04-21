<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\viewhelpers;

use Zend\Authentication\AuthenticationServiceInterface;
use Zend\View\Helper\AbstractHelper;

class ToggleSecondsHelper extends AbstractHelper
{

    /** @var bool */
    private $showSeconds;

    /** @var AuthenticationServiceInterface */
    private $authenticationService;

    public function __construct(
        $showSeconds,
        AuthenticationServiceInterface $authenticationService
    ) {
        $this->authenticationService = $authenticationService;
        $this->showSeconds = $showSeconds;
    }

    public function __invoke()
    {
        $ret = false;

        if ($this->authenticationService->hasIdentity() && ($this->showSeconds === true)) {
            $ret = true;
        }

        return $ret;
    }
}
