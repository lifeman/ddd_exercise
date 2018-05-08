<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 08.05.18 12:09
 */

namespace Lifeman\Cart\Infrastructure;

use Doctrine\ORM\EntityManager;
use Lifeman\Cart\Domain\Cart;
use Lifeman\Cart\Domain\CartRepository;
use Lifeman\Cart\Domain\Item;
use Lifeman\Cart\Utils\ConnectionManager;
use Lifeman\Cart\Utils\EntityManagerFactory;

class DoctrineCartRepositoryTest extends CartRepositoryTest
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function createRepository(): CartRepository
    {
        return new DoctrineCartRepository($this->entityManager);
    }

    protected function flush()
    {
        $this->entityManager->flush();
        $this->entityManager->clear();
    }

    public function setUp()
    {
        ConnectionManager::dropAndCreateDatabase();
        $connection = ConnectionManager::createConnection();
        $this->entityManager = EntityManagerFactory::createEntityManager($connection, [Cart::class, Item::class]);
        return parent::setUp();
    }

    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->getConnection()->close();
    }
}
