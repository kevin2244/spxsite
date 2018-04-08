<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 08/04/2018
 * Time: 00:37
 */

declare(strict_types=1);

namespace App\Spxview;

use Psr\Http\Message\ResponseInterface;
use Zend\Expressive\Template\TemplateRendererInterface;

class SpxRenderer
{
    private $templateRenderer;

    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    public function render() : ResponseInterface
    {

    }
}