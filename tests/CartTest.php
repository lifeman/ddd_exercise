<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 03.05.18 12:36
 */

namespace Lifeman\Cart\Domain;

use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{

    public function testCalculateEmptyCart()
    {
        $cart = new Cart;
        $expected = new CartDetail([], new Price(0.0));
        $this->assertEquals($expected, $cart->calculate());
    }

    public function testAddSingleproductToEmpty()
    {
        $cart = new Cart();
        $cart->add('a', new Price(10));

        $expectedItem = new ItemDetail('a', new Price(10), 1);
        $expected = new CartDetail([$expectedItem], new Price(10));
        $this->assertEquals($expected, $cart->calculate());
    }

    public function testAddTwoDifferentProducts()
    {
        $cart = new Cart();
        $cart->add('a', new Price(10));
        $cart->add('b', new Price(20), 2);

        $expectedItem = [
            new ItemDetail('a', new Price(10.0), 1),
            new ItemDetail('b', new Price(20.0), 2)
        ];

        $expected = new CartDetail($expectedItem, new Price(50.0));

        $this->assertEquals($expected, $cart->calculate());

    }

}

