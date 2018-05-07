<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 03.05.18 11:46
 */

namespace Lifeman\Cart\Domain;

class Item
{
    /**
     * @var string
     */
    private $productId;
    /**
     * @var Price
     */
    private $unitPrice;
    /**
     * @var int
     */
    private $amount;

    public function __construct(string $productId, Price $unitPrice, int $amount)
    {
        $this->productId = $productId;
        $this->unitPrice = $unitPrice;
        $this->amount = $amount;
    }

    public function toDetail(): ItemDetail
    {
        return new ItemDetail($this->productId, $this->unitPrice, $this->amount);
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function add(int $amount)
    {
        $this->checkAmount($amount);
        $this->amount = $this->amount + $amount;
    }

    private function checkAmount($amount)
    {
        if ($amount < 0) {
            throw new AmountMustBePositiveException();
        }
    }

    public function changeAmount(int $amount)
    {
        $this->checkAmount($amount);
        $this->amount = $amount;
    }

    public function calculatePrice(): Price
    {
        return $this->unitPrice->multiply($this->amount);
    }
}