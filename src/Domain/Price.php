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
}