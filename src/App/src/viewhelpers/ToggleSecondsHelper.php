<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\viewhelpers;

use Zend\View\Helper\AbstractHelper;

class ToggleSecondsHelper extends AbstractHelper
{

    /** @var bool */
    private $showSeconds;

    public function __construct($showSecoonds)
    {
        $this->showSeconds = $showSecoonds;
    }

    public function __invoke()
    {
        return $this->showSeconds;
    }
}
