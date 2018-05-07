<?php

namespace Lifeman\Cart\Domain;

class Cart
{
    /**
     * @var Item[]
     */
    private $items = [];

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
        $detailItems = array_map(function (Item $item): ItemDetail {
            return $item->toDetail();
        }, $this->items);

        $prices = array_map(function (Item $item): Price {
            return $item->calculatePrice();
        }, $this->items);

        $totalPrice = Price::sum($prices);

        return new CartDetail(array_values($detailItems), $totalPrice);
    }

    /**
     * @param $productId
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
     * @param $productId
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
}