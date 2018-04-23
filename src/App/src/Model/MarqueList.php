<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 22/04/2018
 * Time: 09:21
 */
namespace App\Model;
use Psr\Container\ContainerInterface;

class MarqueList
{

    public function getMarqueList(ContainerInterface $container) : array
    {
        $marquesDefinition = $container->get('config')['marques'];
        $marquesCurrent = $container->get('config')['marques_current'];
        $marqueList = array_intersect_key($marquesDefinition, $marquesCurrent);

        return $marqueList;
    }
}