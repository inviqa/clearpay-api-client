<?php

namespace Inviqa\Clearpay\Api\DataModels;

use Inviqa\Clearpay\Collection;

class OrderDetails
{
    /**
     * @var Consumer
     */
    private $consumer;
    /**
     * @var Contact
     */
    private $billing;
    /**
     * @var Contact
     */
    private $shipping;
    /**
     * @var ShippingCourier
     */
    private $courier;
    /**
     * @var Collection
     */
    private $items;
    /**
     * @var Collection
     */
    private $discounts;
    /**
     * @var Money
     */
    private $taxAmount;
    /**
     * @var Money
     */
    private $shippingAmount;

    private function __construct(
        Consumer $consumer,
        Contact $billing,
        Contact $shipping,
        ShippingCourier $courier,
        Collection $items,
        Collection $discounts,
        Money $taxAmount,
        Money $shippingAmount
    ) {
        $this->consumer = $consumer;
        $this->billing = $billing;
        $this->shipping = $shipping;
        $this->courier = $courier;
        $this->items = $items;
        $this->discounts = $discounts;
        $this->taxAmount = $taxAmount;
        $this->shippingAmount = $shippingAmount;
    }

    public static function fromState(array $state): self
    {
        return new self(
            Consumer::fromState($state['consumer']),
            Contact::fromState($state['billing']),
            Contact::fromState($state['shipping']),
            ShippingCourier::fromState($state['courier']),
            self::mapItems($state['items'] ?? []),
            self::mapDiscounts($state['discounts'] ?? []),
            Money::fromState($state['taxAmount']),
            Money::fromState($state['shippingAmount'])
        );
    }

    private static function mapItems(array $items): Collection
    {
        return Collection::make($items)->map(function ($item) {
            return Item::fromState($item);
        });
    }

    private static function mapDiscounts(array $discounts): Collection
    {
        return Collection::make($discounts)->map(function ($discount) {
            return Discount::fromState($discount);
        });
    }

    public function consumer(): Consumer
    {
        return $this->consumer;
    }

    public function billing(): Contact
    {
        return $this->billing;
    }

    public function shipping(): Contact
    {
        return $this->shipping;
    }

    public function courier(): ShippingCourier
    {
        return $this->courier;
    }

    public function items(): Collection
    {
        return $this->items;
    }

    public function discounts(): Collection
    {
        return $this->discounts;
    }

    public function taxAmount(): Money
    {
        return $this->taxAmount;
    }

    public function shippingAmount(): Money
    {
        return $this->shippingAmount;
    }
}
