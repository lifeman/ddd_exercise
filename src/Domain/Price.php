<?php
/**
 * ddd_exercise
 * User: lifeman
 * Date: 03.05.18 11:28
 */

namespace Lifeman\Cart\Domain;

class Price
{
    /**
     * @var float
     */
    private $withVat;

    public function __construct(float $withVat)
    {
        $this->withVat = $withVat;
    }

    /**
     * @return float
     */
    public function getWithVat(): float
    {
        return $this->withVat;
    }

    /**
     * @param array $prices
     * @return Price
     */
    public static function sum(array $prices): self
    {
        return array_reduce($prices, function (self $carry, self $price) {
            return $carry->add($price);
        }, new self(0.0));
    }

    public function add(self $adder): self
    {
        $withVat = $this->withVat + $adder->withVat;
        return new self($withVat);
    }

    public function multiply(int $multiplier): self
    {
        $withVat = $this->withVat * $multiplier;
        return new self($withVat);
    }



}