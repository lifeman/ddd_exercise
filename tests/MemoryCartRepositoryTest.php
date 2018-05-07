<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 07.05.18 15:18
 */

namespace Lifeman\Cart\Infrastructure;

use Lifeman\Cart\Domain\CartRepository;

class MemoryCartRepositoryTest extends CartRepositoryTest
{
    protected function createRepository(): CartRepository
    {
        return new MemoryCartRepository();
    }

}