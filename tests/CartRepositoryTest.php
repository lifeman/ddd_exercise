<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 07.05.18 15:19
 */

namespace Lifeman\Cart\Infrastructure;

use Lifeman\Cart\Domain\Cart;
use Lifeman\Cart\Domain\CartDetail;
use Lifeman\Cart\Domain\CartNotFoundException;
use Lifeman\Cart\Domain\CartRepository;
use Lifeman\Cart\Domain\ItemDetail;
use Lifeman\Cart\Domain\Price;
use PHPUnit\Framework\TestCase;

abstract class CartRepositoryTest extends TestCase
{
    /**
     * @var CartRepository
     */
    private $repository;

    public function testAddAndGetSuccessfuly()
    {
        $cart = $this->createCartWithItem(1);
        $this->repository->add($cart);
        $this->flush();

        $foundCart = $this->repository->get('1');
        $expected = $this->getCartDetailWithItem();
        $actual = $foundCart->calculate();
        $this->assertEquals($expected, $actual);
    }

    public function testAddAndRemoveSuccessfully()
    {
        $cart = $this->createCartWithItem(1);
        $this->repository->add($cart);
        $this->flush();

        $this->repository->remove('1');
        $this->flush();

        $this->expectException(CartNotFoundException::class);
        $this->repository->get(1);
    }

    public function testAddedIsTheSameObject()
    {
        $empty = $this->createEmptyCart('1');
        $this->repository->add($empty);
        $empty->add('1', new Price(10));
        $this->flush();

        $found = $this->repository->get('1');
        $expected = $this->getCartDetailWithItem();
        $actual = $found->calculate();
        $this->assertEquals($expected, $actual);
    }

    public function testFlushChangedPersists()
    {
        $empty = $this->createEmptyCart('1');
        $this->repository->add($empty);
        $this->flush();

        $foundEmpty = $this->repository->get('1');
        $foundEmpty->add('1', new Price(10));
        $this->flush();

        $found = $this->repository->get('1');
        $expected = $this->getCartDetailWithItem();
        $actual = $found->calculate();
        $this->assertEquals($expected, $actual);
    }

    public function testGetNotExistingCauseException()
    {
        $this->expectException(CartNotFoundException::class);
        $this->repository->get('1');

    }

    public function testRemoveNotExistingCauseException()
    {
        $this->expectException(CartNotFoundException::class);
        $this->repository->remove('1');
    }

    public function testAddTwoAndGetTwoSuccessfuly()
    {
        $withItem = $this->createCartWithItem('1');
        $this->repository->add($withItem);
        $empty = $this->createEmptyCart('2');
        $this->repository->add($empty);
        $this->flush();

        $found = $this->repository->get('1');
        $this->assertEquals($this->getCartDetailWithItem(), $found->calculate());

        $found = $this->repository->get('2');
        $this->assertEquals($this->getEmptyCartDetail(), $found->calculate());

    }

    private function createCartWithItem(string $id): Cart
    {
        $cart = new Cart($id);
        $cart->add('1', new Price(10), 1);
        return $cart;
    }

    private function flush()
    {
    }

    private function getCartDetailWithItem()
    {
        $item = new ItemDetail('1', new Price(10), 1);
        return new CartDetail([$item], new Price(10));
    }

    private function createEmptyCart(string $id)
    {
        return new Cart($id);
    }

    protected function setUp()
    {
        $this->repository = $this->createRepository();
    }

    abstract protected function createRepository(): CartRepository;

    private function getEmptyCartDetail()
    {
        return new CartDetail([], new Price(0));
    }

}