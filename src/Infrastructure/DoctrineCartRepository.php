<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 08.05.18 11:33
 */

namespace Lifeman\Cart\Infrastructure;

use Doctrine\ORM\EntityManager;
use Lifeman\Cart\Domain\Cart;
use Lifeman\Cart\Domain\CartNotFoundException;

class DoctrineCartRepository
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * DoctrineCartRepository constructor.
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function add(Cart $cart): void
    {
        $this->entityManager->persist($cart);
    }

    public function find(string $id)
    {
        return $this->entityManager->find(Cart::class, $id);
    }

    public function get(string $id): Cart
    {
        return $this->getThrowingException($id);
    }

    private function getThrowingException($id)
    {
        try {
            return $this->find($id);
        } catch (\TypeError $e) {
            throw new CartNotFoundException();
        }
    }

    public function remove(string $id): void
    {
        $cart = $this->getThrowingException($id);
        $this->entityManager->remove($cart);
    }

}