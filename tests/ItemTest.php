<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 03.05.18 12:37
 */

namespace Lifeman\Cart\Domain;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{

    public function testToDetail()
    {
        $item =  new Item('x', new Price(5.0), 2);
        $expected = new DetailItem('x', new Price(5.0), 2);

        Assert::assertEquals($expected, $item->toDetail());
    }

    public function testAdd()
    {
        $item =  new Item('x', new Price(5.0), 2);
        $item->add(5);
        $expected = new DetailItem('x', new Price(5.0), 7);
        Assert::assertEquals($expected, $item->toDetail());

    }

}
