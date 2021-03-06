<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);

namespace AppTest\Model;

use App\Model\MarqueList;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class MarqueListTest extends TestCase
{
    //tests: Model returns populated array
    public function testMarqueList()
    {
        $prophecy = $this->prophesize(ContainerInterface::class);
        $prophecy->get('config')->willReturn([
                'marques' => ['test' => 'Test'],
                'marques_current' => ['test' => 'test']]
        );

        $marqueList = new MarqueList();
        $list = $marqueList->getMarqueList($prophecy->reveal());
        $this->assertCount(1, $list);
    }
}