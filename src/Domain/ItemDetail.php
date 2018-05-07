<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 03.05.18 11:48
 */

namespace Lifeman\Cart\Domain;

class ItemDetail
{
    /**
     * @var string
     */
    private $productId;
    /**
     * @var Price
     */
    private $price;
    /**
     * @var int
     */
    private $amount;

    public function __construct(string $productId, Price $price, int $amount)
    {
        $this->productId = $productId;
        $this->price = $price;
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * @return Price
     */
    public function getPrice(): Price
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }


}