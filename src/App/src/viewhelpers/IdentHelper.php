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

class IdentHelper extends AbstractHelper
{
    private $authenticationService;

    //Use Interface here or concrete AuthenticationService?
    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke()
    {
        return $this->authenticationService->getIdentity();
    }
}

