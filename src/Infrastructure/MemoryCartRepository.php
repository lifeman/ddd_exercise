<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 07.05.18 15:11
 */

namespace Lifeman\Cart\Infrastructure;

use Lifeman\Cart\Domain\Cart;
use Lifeman\Cart\Domain\CartNotFoundException;
use Lifeman\Cart\Domain\CartRepository;

class MemoryCartRepository implements CartRepository
{
    private $carts = [];

    public function add(Cart $cart): void
    {
        $this->carts[$cart->getId()] = $cart;

    }

    public function get(string $id): Cart
    {
        $this->CheckExistence($id);
        return $this->carts[$id];
    }

    public function remove(string $id): void
    {
        $this->CheckExistence($id);
        unset($this->carts[$id]);

    }

    private function CheckExistence($id)
    {
        if (!isset($this->carts[$id])) {
            throw new CartNotFoundException();
        }
    }
}