<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 07.05.18 13:02
 */

namespace Lifeman\Cart\Domain;

use PHPUnit\Framework\TestCase;

class PriceTest extends TestCase
{

    public function testMultiply()
    {
        $price = new Price(10);
        $actual = $price->multiply(10);
        $expected = new Price(100);
        $this->assertEquals($expected, $actual);
    }

    public function testSum()
    {
        $prices = [
            new Price(0.1),
            new Price(9.0),
            new Price(0.9),
        ];
        $actual = Price::sum($prices);
        $expected = new Price(10);
        $this->assertEquals($expected, $actual);
    }

    public function testAdd()
    {
        $a = new Price(10);
        $b = new Price(0.5);
        $actual = $a->add($b);

        $expected = new Price(10.5);
        $this->assertEquals($expected, $actual);
    }
}
