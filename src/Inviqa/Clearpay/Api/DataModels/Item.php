<?php

namespace Inviqa\Clearpay\Api\DataModels;

class Item
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $sku;
    /**
     * @var int
     */
    private $quantity;
    /**
     * @var string
     */
    private $pageUrl;
    /**
     * @var string
     */
    private $imageUrl;
    /**
     * @var Money
     */
    private $price;
    /**
     * @var array
     */
    private $categories;

    private function __construct(
        string $name,
        string $sku,
        int $quantity,
        string $pageUrl,
        string $imageUrl,
        Money $price,
        array $categories = []
    ) {
        $this->name = $name;
        $this->sku = $sku;
        $this->quantity = $quantity;
        $this->pageUrl = $pageUrl;
        $this->imageUrl = $imageUrl;
        $this->price = $price;
        $this->categories = $categories;
    }

    public static function fromState(array $state): self
    {
        return new self(
            $state['name'],
            $state['sku'],
            $state['quantity'],
            $state['pageUrl'],
            $state['imageUrl'],
            Money::fromState($state['price']),
            $state['categories']
        );
    }

    public function name(): string
    {
        return $this->name;
    }

    public function sku(): string
    {
        return $this->sku;
    }

    public function quantity(): int
    {
        return 1;
    }

    public function pageUrl(): string
    {
        return $this->pageUrl;
    }

    public function imageUrl(): string
    {
        return $this->imageUrl;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}
