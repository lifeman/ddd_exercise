<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 07.05.18 15:07
 */

namespace Lifeman\Cart\Domain;

interface CartRepository
{
    public function add(Cart $cart): void;

    /**
     * @param string $id
     * @return Cart
     * @throws CartNotFoundException
     */
    public function get(string $id): Cart;

    /**
     * @param string $id
     * @throws CartNotFoundException
     */
    public function remove(string $id): void;
}