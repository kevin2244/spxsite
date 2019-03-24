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

class ToggleAuthHelper extends AbstractHelper
{
    /** @var AuthenticationServiceInterface */
    private $authenticationService;

    public function __construct(
        AuthenticationServiceInterface $authenticationService
    ) {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke()
    {
        $ret = false;

        if ($this->authenticationService->hasIdentity()) {
            $ret = true;
        }

        return $ret;
    }
}
