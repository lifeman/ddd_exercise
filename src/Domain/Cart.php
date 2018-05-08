<?php

namespace Lifeman\Cart\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Cart
{
    /**
     * @var Collection Item[]
     */
    private $items = [];
    /**
     * @var string
     */
    private $id;

    /**
     * Cart constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
        $this->items = new ArrayCollection();
    }

    public function add(string $productId, Price $unitPrice, int $amount = 1): void
    {
        try {
            $item = $this->find($productId);
            $item->add($amount);
        } catch (ProductNotInCartException $e) {
            $this->items[] = new Item($productId, $unitPrice, $amount);
        }
    }

    /**
     * @param string $productId
     * @throws ProductNotInCartException
     */
    public function remove(string $productId): void
    {
        $key = $this->findKey($productId);
        unset($this->items[$key]);
    }

    /**
     * @param string $productId
     * @param int $amount
     * @throws ProductNotInCartException
     */
    public function changeAmount(string $productId, int $amount): void
    {
        $item = $this->find($productId);
        $item->changeAmount($amount);
    }

    public function calculate(): CartDetail
    {
        $detailItems = $this->items->map(function (Item $item): ItemDetail {
            return $item->toDetail();
        })->getValues();

        $prices = $this->items->map(function (Item $item): Price {
            return $item->calculatePrice();
        })->getValues();

        $totalPrice = Price::sum($prices);

        return new CartDetail(array_values($detailItems), $totalPrice);
    }

    /**
     * @param string $productId
     * @return Item
     * @throws ProductNotInCartException
     */
    private function find($productId): Item
    {
        foreach ($this->items as $item) {
            if ($item->getProductId() === $productId) {
                return $item;
            }
        }
        throw new ProductNotInCartException();
    }

    /**
     * @param string $productId
     * @return string
     * @throws ProductNotInCartException
     */
    private function findKey($productId): string
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProductId() === $productId) {
                return $key;
            }
        }
        throw new ProductNotInCartException();
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

}