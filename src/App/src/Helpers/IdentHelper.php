<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\Helpers;

use Zend\Authentication\AuthenticationServiceInterface;

class IdentHelper
{
    private $authenticationService;

    public function __construct(AuthenticationServiceInterface $authenticationService)
    {
        $this->authenticationService = $authenticationService;
    }

    public function __invoke()
    {
        return $this->authenticationService->getIdentity();
    }
}
