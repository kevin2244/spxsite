<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace App\viewhelpers;

use Zend\View\Helper\AbstractHelper;

class ToggleSchemesHelper extends AbstractHelper
{

    /** @var bool */
    private $showSchemes;

    public function __construct($showSchemes)
    {
        $this->showSchemes = $showSchemes;
    }

    public function __invoke()
    {
        $ret = false;

        if ($this->showSchemes === true) {
            $ret = true;
        }

        return $ret;
    }
}
